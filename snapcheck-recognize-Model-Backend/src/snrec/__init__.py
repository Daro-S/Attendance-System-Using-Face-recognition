import logging
from rich.logging import RichHandler

logging.basicConfig(level=logging.INFO, format="%(message)s", handlers=[RichHandler()])
# import asyncio
# import hashlib
# import json
# import logging
# import os
# import uuid
# from datetime import datetime

# import cv2
# import mediapipe as mp
# import numpy as np
# import pytz
# from aiortc import MediaStreamTrack, RTCPeerConnection, RTCSessionDescription
# from aiortc.contrib.media import MediaBlackhole, MediaPlayer, MediaRecorder, MediaRelay
# from av import VideoFrame
# from dotenv import load_dotenv
# from flask import Flask, Response, abort, render_template, request, url_for
# from flask_rich import RichApplication
# from flask_sqlalchemy import SQLAlchemy
# from keras.models import load_model
# from rich.logging import RichHandler
# from rich.traceback import install
# from sqlalchemy import text
# from sqlalchemy.exc import SQLAlchemyError

# # Constants
# MODEL_PATH = "model/base_model-62I-40E-00005LR.h5"
# FACE_CASCADE_PATH = cv2.data.haarcascades + "haarcascade_frontalface_default.xml"
# SCALE_FACTOR = 1.1
# MIN_NEIGHBORS = 5
# MIN_SIZE = (30, 30)
# FONT = cv2.FONT_HERSHEY_SIMPLEX
# FONT_SCALE = 0.9
# FONT_COLOR = (36, 255, 12)
# FONT_THICKNESS = 2

# # Initialize
# install(show_locals=True)
# load_dotenv()
# rich = RichApplication()
# model = load_model(MODEL_PATH)
# face_cascade = cv2.CascadeClassifier(FACE_CASCADE_PATH)

# # logging.basicConfig(
# #     level=logging.WARNING, format="%(message)s", handlers=[RichHandler()]
# # )
# BASE_LOGGING_LEVEL = "INFO"
# logging.basicConfig(level=BASE_LOGGING_LEVEL)
# logger = logging.getLogger(__name__)
# logger.setLevel(logging.DEBUG)

# pcs = set()
# relay = MediaRelay()


# class VideoTransformTrack(MediaStreamTrack):
#     kind = "video"

#     def __init__(self, track, transform):
#         super().__init__()
#         self.track = track
#         self.transform = transform

#     async def recv(self):
#         frame = frame.to_ndarray(format="bgr24")

#         if self.transform == "cartoon":
#             img = frame.to_ndarray(format="bgr24")

#             # prepare color
#             img_color = cv2.pyrDown(cv2.pyrDown(img))
#             for _ in range(6):
#                 img_color = cv2.bilateralFilter(img_color, 9, 9, 7)
#             img_color = cv2.pyrUp(cv2.pyrUp(img_color))

#             # prepare edges
#             img_edges = cv2.cvtColor(img, cv2.COLOR_RGB2GRAY)
#             img_edges = cv2.adaptiveThreshold(
#                 cv2.medianBlur(img_edges, 7),
#                 255,
#                 cv2.ADAPTIVE_THRESH_MEAN_C,
#                 cv2.THRESH_BINARY,
#                 9,
#                 2,
#             )
#             img_edges = cv2.cvtColor(img_edges, cv2.COLOR_GRAY2RGB)

#             # combine color and edges
#             img = cv2.bitwise_and(img_color, img_edges)

#             # rebuild a VideoFrame, preserving timing information
#             new_frame = VideoFrame.from_ndarray(img, format="bgr24")
#             new_frame.pts = frame.pts
#             new_frame.time_base = frame.time_base
#             return new_frame
#         elif self.transform == "edges":
#             # perform edge detection
#             img = frame.to_ndarray(format="bgr24")
#             img = cv2.cvtColor(cv2.Canny(img, 100, 200), cv2.COLOR_GRAY2BGR)

#             # rebuild a VideoFrame, preserving timing information
#             new_frame = VideoFrame.from_ndarray(img, format="bgr24")
#             new_frame.pts = frame.pts
#             new_frame.time_base = frame.time_base
#             return new_frame
#         elif self.transform == "rotate":
#             # rotate image
#             img = frame.to_ndarray(format="bgr24")
#             rows, cols, _ = img.shape
#             M = cv2.getRotationMatrix2D((cols / 2, rows / 2), frame.time * 45, 1)
#             img = cv2.warpAffine(img, M, (cols, rows))

#             # rebuild a VideoFrame, preserving timing information
#             new_frame = VideoFrame.from_ndarray(img, format="bgr24")
#             new_frame.pts = frame.pts
#             new_frame.time_base = frame.time_base
#             return new_frame
#         else:
#             return frame


# def hash_with_sha256(input_string):
#     return hashlib.sha256(input_string.encode()).hexdigest()


# # # Web cam


# def generate():
#     try:
#         cap = cv2.VideoCapture(0)
#         while cap.isOpened():
#             success, image = cap.read()
#             if not success:
#                 break
#             try:
#                 image = detect_and_recognize_faces(image)
#                 ret, jpeg = cv2.imencode(".jpg", image)
#                 frame = jpeg.tobytes()
#                 yield (
#                     b"--frame\r\n"
#                     b"Content-Type: image/jpeg\r\n\r\n" + frame + b"\r\n\r\n"
#                 )
#             except ValueError as e:
#                 print("Skipped bad frame")
#     except Exception as e:
#         print(f"An error occurred in generate: {e}")


# # Video file
# # def generate():
# # try:
# #     cap = cv2.VideoCapture('src/snrec/Video1.mp4')  # Use video file instead of webcam
# #     while cap.isOpened():
# #         success, image = cap.read()
# #         if not success:
# #             break

# #         image = detect_and_recognize_faces(image)
# #         ret, jpeg = cv2.imencode('.jpg', image)
# #         frame = jpeg.tobytes()
# #         yield (b'--frame\r\n'
# #                b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n\r\n')
# # except Exception as e:
# #     print(f"An error occurred in generate: {e}")


# def detect_and_recognize_faces(image):
#     try:
#         mp_face_detection = mp.solutions.face_detection
#         mp_drawing = mp.solutions.drawing_utils

#         # Initialize MediaPipe Face Detection.
#         face_detection = mp_face_detection.FaceDetection(min_detection_confidence=0.5)

#         # Convert the BGR image to RGB and process it with MediaPipe Face Detection.
#         results = face_detection.process(cv2.cvtColor(image, cv2.COLOR_BGR2RGB))

#         # Draw face detections of each face.
#         if results.detections:
#             for detection in results.detections:
#                 x = int(
#                     detection.location_data.relative_bounding_box.xmin * image.shape[1]
#                 )
#                 y = int(
#                     detection.location_data.relative_bounding_box.ymin * image.shape[0]
#                 )
#                 w = int(
#                     detection.location_data.relative_bounding_box.width * image.shape[1]
#                 )
#                 h = int(
#                     detection.location_data.relative_bounding_box.height
#                     * image.shape[0]
#                 )
#                 cv2.rectangle(image, (x, y), (x + w, y + h), FONT_COLOR, FONT_THICKNESS)
#                 try:
#                     face = preprocess_face(image[y : y + h, x : x + w])
#                     label, confidence = recognize_face(face)
#                     cv2.putText(
#                         image,
#                         f"{label}: {confidence:.2f}%",
#                         (x, y - 10),
#                         FONT,
#                         FONT_SCALE,
#                         FONT_COLOR,
#                         FONT_THICKNESS,
#                     )
#                 except Exception as e:
#                     raise ValueError
#         return image
#     except Exception as e:
#         print(f"An error occurred in detect_and_recognize_faces: {e}")
#         raise e


# def preprocess_face(face):
#     try:
#         face = cv2.resize(face, (227, 227))
#         face = cv2.cvtColor(face, cv2.COLOR_BGR2RGB)
#         face = face / 255.0
#         return np.expand_dims(face, axis=0)
#     except Exception as e:
#         print(f"An error occurred in preprocess_face: {e}")
#         raise e


# def recognize_face(face):
#     try:
#         prediction = model.predict(face)
#         label_index = np.argmax(prediction)
#         confidence = prediction[0][label_index] * 100  # Convert to percentage
#         label = "unknown" if confidence < 50 else label_index
#         return label, confidence
#     except Exception as e:
#         print(f"An error occurred in recognize_face: {e}")


# def create_app(test_config=None):
#     app = Flask(__name__, instance_relative_config=True)
#     app.config.from_mapping(
#         SECRET_KEY=os.getenv("SECRET_KEY", "dev"),
#         RICH_LOGGING=True,
#         SQLALCHEMY_DATABASE_URI=f"mysql+pymysql://{os.getenv('DB_USERNAME')}:{os.getenv('DB_PASSWORD')}@{os.getenv('DB_HOST')}:{os.getenv('DB_PORT')}/{os.getenv('DB_DATABASE')}",
#         SQLALCHEMY_TRACK_MODIFICATIONS=False,
#     )

#     if test_config is None:
#         app.config.from_pyfile("config.py", silent=True)
#     else:
#         app.config.from_mapping(test_config)

#     rich.init_app(app)
#     db = SQLAlchemy(app)

#     try:
#         os.makedirs(app.instance_path)
#     except OSError:
#         pass

#     # to check if the database is connected
#     @app.route("/check-db")
#     def check_db():
#         try:
#             with db.session.begin():
#                 result = db.session.execute(text("SELECT 1"))
#             return "Database is connected."
#         except SQLAlchemyError as e:
#             return f"Database is not connected. Error: {str(e)}", 500

#     @app.route("/")
#     def index():
#         return "Hello, World!"

#     @app.route("/hello")
#     def hello():
#         return "Hello, World!"

#     @app.route("/error")
#     def error():
#         raise Exception

#     @app.route("/v2/face-recognition")
#     def face_recognize_v2():
#         return Response(
#             render_template("face_recognition.html"),
#         )

#     @app.post("/offer")
#     async def offer():
#         params = request.json
#         offer = RTCSessionDescription(sdp=params["sdp"], type=params["type"])

#         pc = RTCPeerConnection()
#         pc_id = "PeerConnection(%s)" % uuid.uuid4()
#         pcs.add(pc)

#         def log_info(msg, *args):
#             logger.info(pc_id + " " + msg, *args)

#         log_info("Created for %s", request.remote_addr)

#         @pc.on("datachannel")
#         def on_datachannel(channel):
#             @channel.on("message")
#             def on_message(message):
#                 if isinstance(message, str) and message.startswith("ping"):
#                     channel.send("pong" + message[4:])

#         @pc.on("connectionstatechange")
#         async def on_connectionstatechange():
#             log_info("Connection state is %s", pc.connectionState)
#             if pc.connectionState == "failed":
#                 await pc.close()
#                 pcs.discard(pc)

#         @pc.on("track")
#         def on_track(track):
#             log_info("Track %s received", track.kind)

#             if track.kind == "audio":
#                 # pc.addTrack(player.audio)
#                 # recorder.addTrack(track)
#                 pass
#             elif track.kind == "video":
#                 pc.addTrack(
#                     VideoTransformTrack(
#                         relay.subscribe(track), transform=params.get("video_transform")
#                     )
#                 )
#                 # if args.record_to:
#                 #     recorder.addTrack(relay.subscribe(track))

#             @track.on("ended")
#             async def on_ended():
#                 log_info("Track %s ended", track.kind)
#                 # await recorder.stop()

#         # handle offer
#         await pc.setRemoteDescription(offer)
#         # await recorder.start()

#         # send answer
#         answer = await pc.createAnswer()
#         await pc.setLocalDescription(answer)

#         await asyncio.sleep(5)

#         return Response(
#             json.dumps(
#                 {"sdp": pc.localDescription.sdp, "type": pc.localDescription.type}
#             ),
#             content_type="application/json",
#         )

#     @app.post("/shutdown")
#     async def shutdown():
#         post_params = request.json
#         if post_params.get("shutdown_key", "") != os.getenv("SHUTDOWN_KEY"):
#             abort(403)

#         coros = [pc.close() for pc in pcs]
#         await asyncio.gather(*coros)
#         pcs.clear()
#         os.kill(os.getpid(), 2)

#     @app.route("/face-recognition")
#     def face_recognition():
#         full_token = request.args.get("_token", default=None)
#         if full_token is None:
#             # Return an error if no token is provided
#             return {"error": "No token provided"}, 400
#         try:
#             id, token = full_token.split("|", 1)
#         except ValueError:
#             return {"error": "Invalid token format"}, 400

#         hashed_token = hash_with_sha256(token)

#         try:
#             with db.session.begin():
#                 # Get the current time in Asia/Phnom_Penh timezone
#                 now = datetime.now(pytz.timezone("Asia/Phnom_Penh")).replace(
#                     tzinfo=None
#                 )

#                 # Check if the token is expired
#                 result = db.session.execute(
#                     text(
#                         "SELECT expires_at FROM personal_access_tokens WHERE id = :id"
#                     ),
#                     {"id": id},
#                 )
#                 record = result.fetchone()
#                 if record is None:
#                     return {"error": "Token not found"}, 404
#                 elif record[0] < now:
#                     return {"error": "Token expired"}, 401

#                 # If the token is not expired, check if the id and token match the database
#                 result = db.session.execute(
#                     text(
#                         "SELECT token FROM personal_access_tokens WHERE id = :id AND token = :token"
#                     ),
#                     {"id": id, "token": hashed_token},
#                 )
#                 record = result.fetchone()
#                 if record is None:
#                     return {"error": "Unauthorized"}, 401

#                 return Response(
#                     generate(), mimetype="multipart/x-mixed-replace; boundary=frame"
#                 )
#         except SQLAlchemyError as e:
#             return {"error": f"Database error: {str(e)}"}, 500

#     print(app.url_map)
#     return app


# if __name__ == "__main__":
#     app = create_app()
#     app.run(debug=True)
