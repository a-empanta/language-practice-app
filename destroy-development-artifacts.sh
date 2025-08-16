#!/bin/bash

docker compose -f compose.dev.yaml down

sudo docker system prune -a --force

docker volume prune -a --force