#!/bin/sh

if [ "$NODE_ENV" = 'development' ]; then
    cd /app && yarn && yarn run dev
else
    cd /app && yarn && yarn build
    printf "Starting nginx...\n\n"
    nginx -g "daemon off;"
fi
