#! /bin/bash

sudo docker-compose -f compose.prod.yaml down --rmi all --volumes --remove-orphans

sudo docker system prune -a --volumes --force
