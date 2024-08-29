# Face Recognition Application

## Description

This project is a face recognition application built using Flask, Keras, OpenCV, and MediaPipe. The application captures video from the webcam, detects faces in the video frames, and recognizes the faces using a trained model.

## Installation

# `snapcheck-recognize` Documentation - How to run

(Step 1 and 2 are only needed once)

- Step 1: Install the [requirements](../requirements.txt)
  ```sh
  $ pip install -r requirements.txt
  ```
- Step 2: Configure the `.env`, using `.env.example` as a guide
- Step 3: Run by
  ```sh
  $ flask --app src/snrec run --debug
  ```

## Usage

Once the local Flask is running, simply open the browser and browse this url : http://localhost:5000/face-detection

## Face Detection

The application uses MediaPipe's Face Detection solution to detect faces in the video frames. Detected faces are highlighted with a rectangle.

## Face Recognition

The detected faces are preprocessed and fed into a trained Keras model for recognition. The model predicts the identity of the face and the confidence of the prediction. If the confidence is below 50%, the face is labeled as 'unknown'. The name of the identity will be labeled during the Face-detection

## Error Handling

The application includes error handling to catch and print exceptions that may occur during face detection and recognition.
