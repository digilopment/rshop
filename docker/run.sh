#!/bin/bash
set -e

IMAGE_NAME="rshop-app"
CONTAINER_NAME="rshop"

echo ">>> Building Docker image: $IMAGE_NAME"
docker build -t $IMAGE_NAME .

echo ">>> Stopping and removing old container if exists..."
docker rm -f $CONTAINER_NAME 2>/dev/null || true

echo ">>> Starting new container: $CONTAINER_NAME"
docker run -d \
  -p 8080:80 \
  -p 3306:3306 \
  --name $CONTAINER_NAME \
  $IMAGE_NAME

echo ">>> Container $CONTAINER_NAME is running."
echo ">>> App: http://localhost:8080"
echo ">>> MySQL: localhost:3306 (user: root, no password by default)"
