import base64
import pathlib
import re
import shutil
import subprocess
import unicodedata
import requests
from sqlalchemy import MetaData, create_engine, event, text
from sqlalchemy.orm import sessionmaker, scoped_session
import os
from dotenv import load_dotenv
import pytest

# //make a soft link idk?
# bad, make copy instead

if not os.path.exists("src/snrec/tests/util"):
    shutil.copytree("src/snrec/util", "src/snrec/tests/util")


from util.string import slugify

load_dotenv()


class DB:
    def __init__(self):
        base_engine = create_engine(
            f"mysql+pymysql://{os.getenv('DB_USERNAME')}:{os.getenv('DB_PASSWORD')}@{os.getenv('DB_HOST')}:{os.getenv('DB_PORT')}/{os.getenv('DB_DATABASE')}"
        )
        base_metadata = MetaData()
        # base_session = scoped_session(sessionmaker(bind=base_engine))

        target_engine = create_engine(
            f"mysql+pymysql://{os.getenv('DB_USERNAME')}:{os.getenv('DB_PASSWORD')}@{os.getenv('DB_HOST')}:{os.getenv('DB_PORT')}/{os.getenv('DB_DATABASE_TEST')}"
        )
        target_metadata = MetaData()
        # target_session = scoped_session(sessionmaker(bind=target_engine))
        # self.engine = create_engine(
        # f"mysql+pymysql://{os.getenv('DB_USERNAME')}:{os.getenv('DB_PASSWORD')}@{os.getenv('DB_HOST')}:{os.getenv('DB_PORT')}/{os.getenv('DB_DATABASE')}"
        # )
        # self.session = scoped_session(sessionmaker(bind=self.engine))

        # @event.listens_for(base_metadata, "column_reflect")
        # def genericize_datatypes(inspector, tablename, column_info):
        #     column_info["type"] = column_info["type"].as_generic(allow_nulltype=True)

        base_conn = base_engine.connect()
        target_conn = target_engine.connect()
        target_metadata.reflect(bind=target_engine)

        # drop all tables in target database
        target_metadata.drop_all(bind=target_engine)

        target_metadata.clear()
        target_metadata.reflect(bind=target_engine)
        base_metadata.reflect(bind=base_engine)

        # create all tables from base database in target database
        for table in base_metadata.sorted_tables:
            table.create(bind=target_engine)

        target_metadata.clear()
        target_metadata.reflect(bind=target_engine)

        # copy all data from base database to target database
        for table in target_metadata.sorted_tables:
            src_table = base_metadata.tables[table.name]
            stmt = table.insert()
            for index, row in enumerate(base_conn.execute(src_table.select())):
                # print(f"Copying row {index} from {table.name}...")
                target_conn.execute(stmt.values(row))

        target_conn.commit()
        base_conn.close()
        target_conn.close()

        self.engine = target_engine
        self.session = scoped_session(sessionmaker(bind=self.engine))


@pytest.fixture(scope="class")
def db():
    return DB().session()


class TestUpdateClass:
    @pytest.mark.order(1)
    def test_select(self, db):
        result = db.execute(text("SELECT username FROM users"))
        assert result.fetchall() == [
            ("admin",),
        ]

    @pytest.mark.order(2)
    def test_select_unlabeled_students(self, db):
        result = db.execute(text("SELECT id FROM students WHERE label_id is NULL"))
        assert result.fetchall() == [
            (26,),
        ]

    @pytest.mark.order(3)
    def test_get_images(self, db):
        result = db.execute(text("SELECT id FROM students WHERE label_id is NULL"))

        for row in result:
            print(row)
            response = requests.get(
                f"{os.getenv('LARAVEL_API')}/student/getStudentImages?student_id={row.id}"
            )
            assert response.status_code == 200

            data = response.json()

            assert data["id"] == "26"
            assert len(data["images"]) > 0
            # assert 1 == 1

    @pytest.mark.order(4)
    def test_pull_image_to_dataset(self, db, tmp_path: pathlib.Path):
        base_path = tmp_path / "images"
        try:
            base_path.mkdir()

            result = db.execute(text("SELECT id FROM students WHERE label_id is NULL"))
            records = result.fetchall()

            for row in result:
                response = requests.get(
                    f"{os.getenv('LARAVEL_API')}/student/getStudentImages?student_id={row[0]}"
                )
                data = response.json()

                image_path = base_path / f"{slugify(data['name'])}"
                image_path.mkdir()
                for i, image in enumerate(data["images"]):
                    image_data = bytes(image[23:], "utf-8")
                    # image is base64 encoded
                    # with open(image_path, "wb") as f:
                    #     f.write(image_data.decode("base64"))  # type: ignore
                    image_file = image_path / f"{slugify(data['name'])}-{i:04}.jpg"
                    print(image_file)
                    image_file.write_bytes(base64.decodebytes(image_data))
                assert image_path.exists()
                assert len(list(image_path.iterdir())) > 0
        finally:
            shutil.rmtree(base_path)
