#! /bin/bash

docker-compose -f compose.prod.yaml down --rmi all --volumes --remove-orphans

docker system prune -a --volumes --force