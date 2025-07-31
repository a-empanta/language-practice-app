#!/bin/bash

cd api && docker-compose -f ../compose.dev.yaml exec workspace php artisan "$@" && cd ../