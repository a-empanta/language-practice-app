#!/bin/bash

sudo docker system prune -a --force

docker volume prune -a --force