#!/bin/bash

docker compose -f compose.prod.yaml down

sudo docker system prune -a --force

docker volume prune -a --force