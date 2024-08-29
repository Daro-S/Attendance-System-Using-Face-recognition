import argparse
import asyncio
import json
import logging
import shutil
import ssl
import threading
import uuid
from pathlib import Path
import hashlib
from datetime import datetime
import aiohttp
import requests
import time

import cv2
import mediapipe as mp
import numpy as np
from aiohttp import web
from aiortc import MediaStreamTrack, RTCPeerConnection, RTCSessionDescription
from aiortc.contrib.media import MediaBlackhole, MediaPlayer, MediaRecorder, MediaRelay
from aiortc.contrib.signaling import create_signaling, add_signaling_arguments, BYE

from av import VideoFrame
from dotenv import load_dotenv
from keras.models import load_model
from rich import print
from rich.logging import RichHandler
from rich.traceback import install

from aiohttp_session import setup, get_session, session_middleware
from sqlalchemy import create_engine, text
from aiohttp_session.cookie_storage import EncryptedCookieStorage
from sqlalchemy.orm import scoped_session, sessionmaker
from sqlalchemy.exc import SQLAlchemyError
from aiohttp.web import Request

# from cryptography.fernet import Fernet
import os
import pytz

from src.snrec.jobs.database import update_dataset_job, load_labels_to_database
from src.snrec.global_store import global_store
from src.snrec.util.model import load_transferred_model


ROOT = Path(__file__).parent
STATIC_PATH = ROOT / "static"
TEMPLATE_PATH = ROOT / "templates"
FRAME_BASE_PATH = STATIC_PATH / "frames"
MODEL_BASE_PATH = Path("model")
# nn_model_path = "model/model_mobilenet-base.h5"
FACE_CASCADE_PATH = cv2.data.haarcascades + "haarcascade_frontalface_default.xml"
SCALE_FACTOR = 1.1
MIN_NEIGHBORS = 5
MIN_SIZE = (30, 30)
FONT = cv2.FONT_HERSHEY_SIMPLEX
FONT_SCALE = 0.9
FONT_COLOR = (36, 255, 12)
FONT_THICKNESS = 2
BASE_LOGGING_LEVEL = logging.INFO

install(show_locals=True)
load_dotenv()

logger = logging.getLogger(__file__)
logger.setLevel(BASE_LOGGING_LEVEL)

global_store.set("nn_model_path", os.getenv("NN_MODEL_PATH"))
load_transferred_model()
nn_model_path = global_store.get("nn_model_path")

pcs = set()
relay = MediaRelay()
model = load_model(str(nn_model_path))
print(model.summary())
face_cascade = cv2.CascadeClassifier(FACE_CASCADE_PATH)
mp_face_detection = mp.solutions.face_detection
# Initialize MediaPipe Face Detection.
face_detection = mp_face_detection.FaceDetection(min_detection_confidence=0.5)
mark_threshold = int(os.getenv("MARK_THRESHOLD", 96))
recognition_threshold = int(os.getenv("RECOGNITION_THRESHOLD", 50))

print(f"{mark_threshold = }, {type(mark_threshold) = }")
print(f"{recognition_threshold = }, {type(recognition_threshold) = }")

# Set up SQLAlchemy
engine = create_engine(
    f"mysql+pymysql://{os.getenv('DB_USERNAME')}:{os.getenv('DB_PASSWORD')}@{os.getenv('DB_HOST')}:{os.getenv('DB_PORT')}/{os.getenv('DB_DATABASE')}"
)
db = scoped_session(sessionmaker(bind=engine))

# Set up sessions

fernet_key = os.urandom(32)
secret_key = fernet_key
res_attendance_id = None

global_store.set("current_update_job", None)
global_store.set("frame_counter", 0)

if FRAME_BASE_PATH.exists():
    shutil.rmtree(FRAME_BASE_PATH)

FRAME_BASE_PATH.mkdir(parents=True, exist_ok=True)
(FRAME_BASE_PATH / "cropped").mkdir(parents=True, exist_ok=True)


def store_frame(frame):
    # frame_path = FRAME_BASE_PATH / f"frame_{global_store.get('frame_counter')}.jpg"
    # cv2.imwrite(str(frame_path), frame)
    pass


def store_cropped_frame(frame):
    # frame_path = (
    #     FRAME_BASE_PATH / "cropped" / f"frame_{global_store.get('frame_counter')}.jpg"
    # )

    # cv2.imwrite(str(frame_path), frame)
    pass


class VideoTransformTrack(MediaStreamTrack):
    """A video stream track that transforms frames."""

    kind = "video"

    def __init__(self, track: MediaStreamTrack, transform: str):
        super().__init__()
        self.track = track
        self.transform = transform
        self.time_threshold = 1e9 / 5
        self._last_received_time = None
        self._last_frame = None
        self._is_transforming = False

    async def recv(self) -> VideoFrame:
        # print("Receiving frame")
        frame: VideoFrame = await self.track.recv()

        if self._is_transforming:
            print("Dropping frame")
            return self._last_frame

        self._is_transforming = True

        new_frame = self.transform_frame(frame)
        self._last_frame = new_frame

        self._is_transforming = False

        return new_frame

    def transform_frame(self, frame: VideoFrame) -> VideoFrame:
        if self.transform == "cartoon":
            img = frame.to_ndarray(format="bgr24")

            # prepare color
            img_color = cv2.pyrDown(cv2.pyrDown(img))
            for _ in range(6):
                img_color = cv2.bilateralFilter(img_color, 9, 9, 7)
            img_color = cv2.pyrUp(cv2.pyrUp(img_color))

            # prepare edges
            img_edges = cv2.cvtColor(img, cv2.COLOR_RGB2GRAY)
            img_edges = cv2.adaptiveThreshold(
                cv2.medianBlur(img_edges, 7),
                255,
                cv2.ADAPTIVE_THRESH_MEAN_C,
                cv2.THRESH_BINARY,
                9,
                2,
            )
            img_edges = cv2.cvtColor(img_edges, cv2.COLOR_GRAY2RGB)

            # combine color and edges
            img = cv2.bitwise_and(img_color, img_edges)

            # rebuild a VideoFrame, preserving timing information
            new_frame = VideoFrame.from_ndarray(img, format="bgr24")
            new_frame.pts = frame.pts
            new_frame.time_base = frame.time_base
            return new_frame
        elif self.transform == "edges":
            # perform edge detection
            img = frame.to_ndarray(format="bgr24")
            img = cv2.cvtColor(cv2.Canny(img, 100, 200), cv2.COLOR_GRAY2BGR)

            # rebuild a VideoFrame, preserving timing information
            new_frame = VideoFrame.from_ndarray(img, format="bgr24")
            new_frame.pts = frame.pts
            new_frame.time_base = frame.time_base
            return new_frame
        elif self.transform == "rotate":
            # rotate image
            img = frame.to_ndarray(format="bgr24")
            rows, cols, _ = img.shape
            M = cv2.getRotationMatrix2D((cols / 2, rows / 2), frame.time * 45, 1)
            img = cv2.warpAffine(img, M, (cols, rows))

            # rebuild a VideoFrame, preserving timing information
            new_frame = VideoFrame.from_ndarray(img, format="bgr24")
            new_frame.pts = frame.pts
            new_frame.time_base = frame.time_base
            return new_frame
        elif self.transform == "face":
            img = frame.to_ndarray(format="bgr24")
            try:
                global_store.set("frame_counter", global_store.get("frame_counter") + 1)
                new_image = detect_and_recognize_faces(img)
                store_frame(new_image)

                new_frame = VideoFrame.from_ndarray(new_image, format="bgr24")
                new_frame.pts = frame.pts
                new_frame.time_base = frame.time_base
                return new_frame
            except Exception as e:
                print(f"An error occurred in VideoTransformTrack: {e}")
                return frame
        else:
            return frame


LARAVEL_API = os.getenv("LARAVEL_API")


def mark_attendance(label_id, attendance_id, confidence):
    url = f"{LARAVEL_API}/attendance/mark_student_attendance"
    data = {
        "captured_image": "",
        "captured_at": datetime.now(pytz.timezone("Asia/Phnom_Penh")).strftime(
            "%Y-%m-%d %H:%M:%S"
        ),
        "label_id": label_id,
        "attendance_id": attendance_id,
        "probability": confidence,
    }

    logger.info(data)
    try:
        response = requests.post(url, data=data)
        response.raise_for_status()  # Raises a HTTPError if the status is 4xx, 5xx
        response_dict = json.loads(response.text)

        if response_dict["code"] == 200:
            success_marked_labels[response_dict["attendance_id"]].append(
                response_dict["label_id"]
            )

        if response_dict["code"] == 201:
            if (
                response_dict["label_id"]
                not in success_marked_labels[response_dict["attendance_id"]]
            ):
                success_marked_labels[response_dict["attendance_id"]].append(
                    response_dict["label_id"]
                )

    except requests.exceptions.HTTPError as errh:
        print(f"Http Error: {errh}")
    except requests.exceptions.ConnectionError as errc:
        print(f"Error Connecting: {errc}")
    except requests.exceptions.Timeout as errt:
        print(f"Timeout Error: {errt}")
    except requests.exceptions.RequestException as err:
        print(f"Something went wrong: {err}")


success_marked_labels = {}


def detect_and_recognize_faces(image):
    global start_time, success_marked_labels, res_attendance_id
    logger.info(success_marked_labels)
    try:
        last_label = None
        last_confidence = None
        results = face_detection.process(cv2.cvtColor(image, cv2.COLOR_BGR2RGB))
        if results.detections:
            for detection in results.detections:
                x = int(
                    detection.location_data.relative_bounding_box.xmin * image.shape[1]
                )
                y = int(
                    detection.location_data.relative_bounding_box.ymin * image.shape[0]
                )
                w = int(
                    detection.location_data.relative_bounding_box.width * image.shape[1]
                )
                h = int(
                    detection.location_data.relative_bounding_box.height
                    * image.shape[0]
                )
                cv2.rectangle(image, (x, y), (x + w, y + h), FONT_COLOR, FONT_THICKNESS)
                try:
                    face = preprocess_face(image[y : y + h, x : x + w])
                    face_no_norm = image[y : y + h, x : x + w]
                    face_no_norm = cv2.resize(face_no_norm, (224, 224))
                    store_cropped_frame(face_no_norm)
                    label, confidence = recognize_face(face)
                    last_label = label
                    last_confidence = confidence
                    logger.info(last_confidence)
                    cv2.putText(
                        image,
                        f"{label}: {confidence:.2f}%",
                        (x, y - 10),
                        FONT,
                        FONT_SCALE,
                        FONT_COLOR,
                        FONT_THICKNESS,
                    )
                except Exception as e:
                    raise ValueError
        if last_label is not None and last_confidence >= mark_threshold:
            if res_attendance_id not in success_marked_labels:
                success_marked_labels[res_attendance_id] = []
            if last_label not in success_marked_labels[res_attendance_id]:
                mark_attendance(
                    last_label, int(res_attendance_id), int(last_confidence * 100)
                )
        return image
    except Exception as e:
        print(f"An error occurred in detect_and_recognize_faces: {e}")
        raise e


def preprocess_face(face):
    try:
        face = cv2.resize(face, (224, 224))
        face = cv2.cvtColor(face, cv2.COLOR_BGR2RGB)
        face = face / 255.0
        return np.expand_dims(face, axis=0)
    except Exception as e:
        print(f"An error occurred in preprocess_face: {e}")
        raise e


def recognize_face(face):
    try:
        prediction = model.predict(face)
        print(prediction)
        label_index = np.argmax(prediction)
        confidence = prediction[0][label_index] * 100  # Convert to percentage
        label = "unknown" if confidence < recognition_threshold else label_index
        return label, confidence  # Multiply by 100 and convert to integer
    except Exception as e:
        print(f"An error occurred in recognize_face: {e}")


async def index(request: Request):
    content = open(TEMPLATE_PATH / "face_recognition.html", "r").read()
    return web.Response(content_type="text/html", text=content)


async def offer(request: Request):
    params = await request.json()
    offer = RTCSessionDescription(sdp=params["sdp"], type=params["type"])

    pc = RTCPeerConnection()
    pc_id = f"PeerConnection({uuid.uuid4()})"
    pcs.add(pc)

    def log_info(msg, *args):
        logger.info(pc_id + " " + msg, *args)

    log_info("Create    d for %s", request.remote)

    @pc.on("datachannel")
    def on_datachannel(channel):
        @channel.on("message")
        def on_message(message):
            if isinstance(message, str) and message.startswith("ping"):
                channel.send("pong" + message[4:])

    @pc.on("connectionstatechange")
    async def on_connectionstatechange():
        log_info("Connection state is %s", pc.connectionState)
        if pc.connectionState == "failed":
            await pc.close()
            pcs.discard(pc)

    @pc.on("track")
    def on_track(track):
        log_info("Track %s received", track.kind)

        if track.kind == "audio":
            pass
        elif track.kind == "video":
            pc.addTrack(
                VideoTransformTrack(
                    relay.subscribe(track, buffered=False),
                    transform=params.get("video_transform"),
                )
            )

        @track.on("ended")
        async def on_ended():
            log_info("Track %s ended", track.kind)
            # await recorder.stop()

    await pc.setRemoteDescription(offer)

    answer = await pc.createAnswer()
    if answer is None:
        return web.Response(
            content_type="application/json",
            text=json.dumps(
                {"error": "Failed to create answer", "sdp": pc.localDescription.sdp}
            ),
            status=500,
        )
    await pc.setLocalDescription(answer)

    return web.Response(
        content_type="application/json",
        text=json.dumps(
            {
                "sdp": pc.localDescription.sdp,
                "type": pc.localDescription.type,
            }
        ),
    )


def hash_with_sha256(input_string):
    return hashlib.sha256(input_string.encode()).hexdigest()


async def face_recognition(request: Request):

    try:
        # Get the session

        session = await get_session(request)
        # Extract the token from the POST request
        data = await request.post()
        full_token = data.get("personal_access_token", None)
        global res_attendance_id
        res_attendance_id = data.get("attendance_id", None)
        if full_token is None:
            # Return an error if no token is provided
            return web.json_response({"error": "No token provided"}, status=400)

        try:
            id, token = full_token.split("|", 1)
        except ValueError:
            return web.json_response({"error": "Invalid token format"}, status=400)

        hashed_token = hash_with_sha256(token)

        # Begin a session
        db_session = db()
        try:

            # Get the current time in Asia/Phnom_Penh timezone
            now = datetime.now(pytz.timezone("Asia/Phnom_Penh")).replace(tzinfo=None)

            # Check if the token is expired
            result = db_session.execute(
                text("SELECT expires_at FROM personal_access_tokens WHERE id = :id"),
                {"id": id},
            )
            record = result.fetchone()
            if record is None:
                return web.json_response({"error": "Token not found"}, status=404)
            elif record[0] < now:
                return web.json_response({"error": "Token expired"}, status=401)

            # If the token is not expired, check if the id and token match the database
            result = db_session.execute(
                text(
                    "SELECT token FROM personal_access_tokens WHERE id = :id AND token = :token"
                ),
                {"id": id, "token": hashed_token},
            )
            record = result.fetchone()
            if record is None:
                return web.json_response({"error": "Unauthorized"}, status=401)

            # Generate the response
            response = await index(request)
            return response

        except SQLAlchemyError as e:
            # Rollback the transaction in case of error
            db_session.rollback()
            return web.json_response({"error": f"Database error: {str(e)}"}, status=500)
        finally:
            # Close the session
            db_session.close()
    except Exception as e:
        return web.json_response({"error": str(e)}, status=500)


async def update_dataset(request: Request):
    try:
        # session = await get_session(request)
        # data = await request.post()
        # full_token = data.get("personal_access_token", None)
        # if full_token is None:
        #     return web.json_response({"error": "No token provided"}, status=400)

        # try:
        #     id, token = full_token.split("|", 1)
        # except ValueError:
        #     return web.json_response({"error": "Invalid token format"}, status=400)

        # hashed_token = hash_with_sha256(token)

        db_session = db()
        try:
            # now = datetime.now(pytz.timezone("Asia/Phnom_Penh")).replace(tzinfo=None)
            # result = db_session.execute(
            #     text("SELECT expires_at FROM personal_access_tokens WHERE id = :id"),
            #     {"id": id},
            # )
            # record = result.fetchone()
            # if record is None:
            #     return web.json_response({"error": "Token not found"}, status=404)
            # elif record[0] < now:
            #     return web.json_response({"error": "Token expired"}, status=401)

            # result = db_session.execute(
            #     text(
            #         "SELECT token FROM personal_access_tokens WHERE id = :id AND token = :token"
            #     ),
            #     {"id": id, "token": hashed_token},
            # )
            # record = result.fetchone()
            # if record is None:
            #     return web.json_response({"error": "Unauthorized"}, status=401)

            # Generate the response
            # current_update_job = asyncio.create_task(update_dataset_job(db_session))
            # current_update_job.add_done_callback(lambda x: print(x.result()))
            current_update_job = threading.Thread(
                target=update_dataset_job, args=(db_session,)
            )
            current_update_job.start()

            global_store.set("current_update_job", current_update_job)
            return web.json_response(
                {
                    "message": "Update job started",
                },
                status=200,
            )

        except SQLAlchemyError as e:
            db_session.rollback()
            return web.json_response({"error": f"Database error: {str(e)}"}, status=500)
        finally:
            db_session.close()
    except Exception as e:
        return web.json_response({"error": str(e)}, status=500)


async def load_labels(request: Request):
    db_conn = db()
    try:
        load_labels_to_database(db_conn)

        return web.json_response(
            {
                "message": "Labels loaded",
            },
            status=200,
        )
    except Exception as e:
        logger.error(f"An error occurred in load_labels: {e}")
        return web.json_response({"error": str(e)}, status=500)


def notify_swap_model():
    global model, nn_model_path
    print(model.summary())
    if global_store.get("nn_model_path") == nn_model_path:
        logger.info(f"Model not swapped: {global_store.get('nn_model_path')}")
        return

    if global_store.get("nn_model_path").name.endswith(".h5"):
        model = load_model(str(global_store.get("nn_model_path")))
        global_store.set("nn_model_path", global_store.get("nn_model_path"))
        nn_model_path = global_store.get("nn_model_path")
        logger.info(f"Model swapped: {global_store.get('nn_model_path')}")

    else:
        logger.info(f"Model not swapped: {global_store.get('nn_model_path')}")


async def override_model(request: Request):
    try:
        data = await request.post()
        model_path = data.get("model_path", None)
        if not isinstance(model_path, str):
            return web.json_response({"error": "Invalid model path"}, status=400)
        if model_path is None:
            return web.json_response({"error": "No model path provided"}, status=400)
        if not Path(model_path).exists():
            return web.json_response({"error": "Model path does not exist"}, status=400)
        global_store.set("nn_model_path", model_path)
        # model = load_model(model_path)
        notify_swap_model()
        return web.json_response(
            {
                "message": "Model path updated",
            },
            status=200,
        )
    except Exception as e:
        return web.json_response({"error": str(e)}, status=500)


async def notify_done_training(request: Request):
    try:
        load_transferred_model()
        notify_swap_model()
        return web.json_response(
            {
                "message": "Model updated",
            },
            status=200,
        )
    except Exception as e:
        return web.json_response({"error": str(e)}, status=500)


async def on_shutdown(app):
    coros = [pc.close() for pc in pcs]
    await asyncio.gather(*coros)
    pcs.clear()


if __name__ == "__main__":
    parser = argparse.ArgumentParser(
        description="WebRTC audio / video / data-channels demo"
    )
    parser.add_argument("--cert-file", help="SSL certificate file (for HTTPS)")
    parser.add_argument("--key-file", help="SSL key file (for HTTPS)")
    parser.add_argument(
        "--host", default="0.0.0.0", help="Host for HTTP server (default: 0.0.0.0)"
    )
    parser.add_argument(
        "--port", type=int, default=9721, help="Port for HTTP server (default: 9721)"
    )
    parser.add_argument("--record-to", help="Write received media to a file.")
    parser.add_argument("--verbose", "-v", action="count")
    add_signaling_arguments(parser)

    args = parser.parse_args()

    if args.verbose:
        logging.basicConfig(level=logging.DEBUG)
    else:
        logging.basicConfig(level=logging.INFO)

    if args.cert_file:
        ssl_context = ssl.SSLContext()
        ssl_context.load_cert_chain(args.cert_file, args.key_file)
    else:
        ssl_context = None

    signaling = create_signaling(args)

    app = web.Application(
        middlewares=[session_middleware(EncryptedCookieStorage(secret_key))]
    )
    app.on_shutdown.append(on_shutdown)
    # app.router.add_get("/", index)
    app.router.add_post("/offer", offer)
    app.router.add_post("/", face_recognition)
    app.router.add_static("/static", STATIC_PATH, show_index=True)
    app.router.add_get("/experimental/update_dataset", update_dataset)
    app.router.add_get("/experimental/load_labels", load_labels)
    app.router.add_post("/experimental/override_model", override_model)
    app.router.add_get("/experimental/notify_done_training", notify_done_training)

    web.run_app(
        app, access_log=logger, host=args.host, port=args.port, ssl_context=ssl_context
    )
