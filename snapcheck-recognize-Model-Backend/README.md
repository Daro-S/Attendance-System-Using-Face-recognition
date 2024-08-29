# snapcheck-recognize

- [snapcheck-recognize](#snapcheck-recognize)
  - [Description](#description)
  - [Requirements](#requirements)
  - [Installation](#installation)
  - [Acknowledgements](#acknowledgements)

## Description

`snapcheck-recognize` is the system that trains, and recognizes faces in feeds of images. It is a part of the SnapCheck project.

## Requirements

- Python 3.10
- and 2 GB of free space

## Installation

Create a virtual environment and install the requirements.

```bash
python3 -m venv .venv
source .venv/bin/activate
```

Windows:

```powershell
./.venv/Scripts/activate
```

Install the requirements.

```bash
pip install -r requirements.txt
```

Install opencv-python (opencv-python-headless for headless systems)

```bash
pip install opencv-python
# or
pip install opencv-python-headless
```

Set the environment variables by copying the `.env.example` file to `.env` and setting the values.

Get your API kaggle key from [here](https://www.kaggle.com/docs/api) and put it into `~/.kaggle/kaggle.json`.

Make sure to change the username and stuffs in the `src/snrec/jobs/database.py` file.

```bash

## Running

Run the script using

```bash
python -m src.snrec.main
```

## Acknowledgements

This project is developed for the CADT Capstone Project II.
