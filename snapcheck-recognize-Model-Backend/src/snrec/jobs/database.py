import base64
import logging
import os
from pathlib import Path
import shutil
import time
from typing import Any, Optional, Sequence
import zipfile

import requests
from sqlalchemy import Row
import sqlalchemy
from sqlalchemy import text
from sqlalchemy.orm import Session
from rich.console import Console

console = Console()

import kaggle
import schedule

from src.snrec.util.string import slugify
from src.snrec.global_store import global_store

job_status_log = Path("update_dataset_job.status")
global_store.set("update_schedule", None)

logger = logging.getLogger(__file__)


def check_rmtree_finished(path: Path):
    wait_times = [2**i for i in range(10)]
    wait_times.reverse()
    for wait_time in wait_times:
        if path.exists():
            time.sleep(wait_time)
        else:
            return
    raise Exception(f"Failed to remove {path}")


def check_file_exists(path: Path):
    wait_times = [2**i for i in range(10)]
    wait_times.reverse()
    for wait_time in wait_times:
        if not path.exists():
            time.sleep(wait_time)
        else:
            return
    raise Exception(f"Failed to move {path}")


def get_images(db_conn: Session):
    base_dataset_path = Path("store/new-transfer-data")
    dataset_path = base_dataset_path / "New-Data"
    if dataset_path.exists():
        logger.info("Removing existing dataset")
        shutil.rmtree(dataset_path)
    time.sleep(1)
    check_rmtree_finished(dataset_path)
    dataset_path.mkdir(parents=True, exist_ok=True)

    with open(dataset_path / "fileofshame.txt", "w") as f:
        f.write("some text")

    result = db_conn.execute(
        text("SELECT id FROM students WHERE label_id is NULL AND deleted_at IS NULL")
    )
    records = result.fetchall()
    if not records:
        print("no records?")
        return

    with job_status_log.open("w") as f:
        f.write("START\n")

        for record in records:
            f.write(f"{record}\n")

        f.write("PROCESSING\n")

        for record in records:
            f.write(f"{record}\n")

            response = requests.get(
                f"{os.getenv('LARAVEL_API', 'http://127.0.0.1/api')}/student/getStudentImages?student_id={record[0]}"
            )

            data = response.json()
            student_id = data["id"]
            student_name = data["name"]
            student_images = data["images"]

            logger.info(f"Student {student_name} has {len(student_images)} images")

            student_path = dataset_path / slugify(student_name)

            if student_path.exists():
                logger.warning(f"Student {student_path} already exists")
            student_path.mkdir()

            for i, image in enumerate(student_images):
                image_path = student_path / f"{slugify(student_name)}_{i:04}.jpg"
                image_data = bytes(image[22:], "utf-8")
                image_path.write_bytes(base64.decodebytes(image_data))

            f.write(f"{record} DONE\n")

        f.write("DONE\n")


# async def zip_up_images_into_dataset():
#     shutil.make_archive("store/new-transfer-data", "zip", "store/new-transfer-data/New-Data")
def init_kaggle():
    kaggle.api.authenticate()


def upload_dataset_to_kaggle():
    response = kaggle.api.dataset_create_version(
        "store/",
        dir_mode="zip",
        version_notes="New dataset version",
    )

    return response


def force_run_new_version():
    status_response = kaggle.api.kernels_status("tsothyrak/snapcheck-transfer-learning")
    logger.info(f"Status response: {status_response}")

    if status_response["status"] == "running":
        raise Exception("Kernel is already running")

    # TODO: Missing a whole bunch of stuffs

    response = kaggle.api.kernels_pull(
        "tsothyrak/snapcheck-transfer-learning", "kernel-store", metadata=True
    )
    logger.info(f"Kernel pull response: {response}")

    response = kaggle.api.kernels_push("kernel-store")

    return response


def notify_server():
    logger.info("Notifying server")
    logger.info(f"Server base: {os.getenv('BACKEND_BASE')}")
    response = requests.get(
        f"{os.getenv('BACKEND_BASE')}/experimental/notify_done_training"
    )
    logger.info(f"Server notification response: {response}")


def upload_transfer_data():
    kaggle.api.dataset_create_version(
        "store-transfer/", dir_mode="zip", version_notes="New transfer data version"
    )


def update_transfer_data():
    base_dataset_path = Path(
        "store-transfer/transfer-learning-base/Transfer-learning-data-v2/Transfer-learning-data"
    )
    if base_dataset_path.exists():
        shutil.rmtree(base_dataset_path)

    check_rmtree_finished(base_dataset_path)
    base_dataset_path.mkdir(parents=True, exist_ok=True)

    logger.info("Moving the new stuffs")

    for file in Path("kernel-output/export").iterdir():
        shutil.move(file, base_dataset_path / file.name)
        check_file_exists(base_dataset_path / file.name)
        if file.name.startswith("transfer-model"):
            shutil.copy(Path(base_dataset_path, file.name), Path("model", file.name))
            Path(base_dataset_path, file.name).rename(
                base_dataset_path / "model_mobilenet-base.h5"
            )

    logger.info("Moved the new stuffs")

    upload_transfer_data()
    notify_server()


def check_for_finished(db_conn: Session):
    status_response = kaggle.api.kernels_status("tsothyrak/snapcheck-transfer-learning")
    logger.info(f"Status response: {status_response}")

    update_schedule = global_store.get("update_schedule")

    if update_schedule is None:
        raise Exception("What do you mean, no update schedule? How did we get here?")
    else:
        if status_response["status"] == "complete":
            schedule.cancel_job(update_schedule)
            with job_status_log.open("a") as f:
                f.write("COMPLETE\n")

        elif status_response["status"] == "failed":
            schedule.cancel_job(update_schedule)
            with job_status_log.open("a") as f:
                f.write("FAILED\n")
                f.write(f"Error: {status_response['error']}\n")

        elif status_response["status"] == "error":
            schedule.cancel_job(update_schedule)
            with job_status_log.open("a") as f:
                f.write("ERROR\n")
                f.write(f"Error: {status_response['error']}\n")

        elif status_response["status"] == "running":
            with job_status_log.open("a") as f:
                f.write("RUNNING\n")
            return

        else:
            schedule.cancel_job(update_schedule)

    if status_response["status"] == "complete":
        # download the new stuffs
        kaggle.api.kernels_output(
            "tsothyrak/snapcheck-transfer-learning", "kernel-output"
        )

        # unzip the new stuffs
        with zipfile.ZipFile("kernel-output/export_data.zip", "r") as zip_ref:
            logger.info("Unzipping the new stuffs")
            zip_ref.extractall("kernel-output/export")
            logger.info("Unzipped the new stuffs")

        # update the labels
        load_labels_to_database(db_conn)

        # move the new stuffs to the right place
        update_transfer_data()
        global_store.set("update_over", True)


def update_dataset_job(db_conn: Session):
    try:
        init_kaggle()
        global_store.set("update_over", False)

        get_images(db_conn)
        logger.info("Images fetched")
        # await zip_up_images_into_dataset()
        dataset_response = upload_dataset_to_kaggle()
        logger.info(f"Dataset response: {dataset_response}")
        kernel_response = force_run_new_version()
        logger.info(f"Kernel pushed")

        update_schedule = schedule.every(5).seconds.do(check_for_finished, db_conn)
        global_store.set("update_schedule", update_schedule)

        while global_store.get("update_over") == False:
            print("Running schedule")
            schedule.run_pending()
            time.sleep(1)

    except Exception as e:
        # logger.error(f"ERROR: {e}")
        console.print_exception()
        with job_status_log.open("a") as f:
            f.write(f"ERROR: {e}\n")


def load_labels_to_database(db_conn: Session):
    with open("kernel-output/export/labels.txt") as f:
        labels = f.read().splitlines()

        labels_strip = [label.strip() for label in labels]

        labels_slug = [slugify(label) for label in labels_strip]

        result = db_conn.execute(
            text(
                "SELECT id, name FROM students WHERE label_id is NULL AND deleted_at IS NULL"
            )
        )
        records = result.fetchall()

        logger.info(f"Updating {len(records)} records with {len(labels_slug)} labels")

        for record in records:
            record_slug = slugify(record[1])
            for i, label in enumerate(labels_slug):
                if record_slug == label:
                    print(
                        f"Matched {record_slug} to {label} on label_id {i}, id {record[0]}"
                    )
                    db_conn.execute(
                        text(
                            "UPDATE students SET label_id = :label_id WHERE students.id = :id"
                        ),
                        {"label_id": i, "id": record[0]},
                    )

                    break

        logger.info("Labels updated")

        db_conn.commit()
