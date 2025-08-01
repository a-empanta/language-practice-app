#!/bin/bash

cd laravel-api && docker-compose -f ../compose.dev.yaml exec workspace php artisan "$@" && cd ../