#!/bin/sh

if [ "$NODE_ENV" = 'development' ]; then
    cd /app && yarn && yarn run dev
else
    printf "Starting nginx...\n\n"
    nginx -g "daemon off;"
fi
