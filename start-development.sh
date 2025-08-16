#! /bin/bash

sudo docker compose -f compose.dev.yaml up -d --build

sudo docker system prune -a --force
