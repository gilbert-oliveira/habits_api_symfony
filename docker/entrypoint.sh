#!/bin/bash

if [ ! -d "vendor" ]; then
    composer install
fi

if [ ! -f ".env" ]; then
    cp .env.dist .env
fi

# start the command passed to the container
exec "$@"