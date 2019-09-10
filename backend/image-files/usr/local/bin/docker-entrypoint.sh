#!/bin/sh

if [ "$NODE_ENV" = 'development' ]; then
    printf "Build and run server for dev...\n\n"
    cd /app && yarn && yarn run dev
else
    printf "Build for prod...\n\n"
    cd /app && yarn && yarn build

    printf "Starting nginx...\n\n"
    nginx -g "daemon off;"
fi
