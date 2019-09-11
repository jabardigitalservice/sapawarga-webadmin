#!/bin/sh

if [ "$NODE_ENV" = 'development' ]; then
    printf "Build and run server for development...\n\n"
    cd /app && yarn && yarn run dev
    printf "Build and run server finished\n\n"
else
    printf "Rebuild for prodution...\n\n"
    cd /app && yarn && yarn build
    printf "Build finished\n\n"

    printf "Starting nginx...\n\n"
    nginx -g "daemon off;"
    printf "Nginx started\n\n"
fi
