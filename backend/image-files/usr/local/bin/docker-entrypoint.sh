#!/bin/sh

if [ "$VUE_ENV_DEV" = 1 ]; then
    cd /app && yarn && yarn run dev
else
    printf "Starting nginx...\n\n"
    nginx -g "daemon off;"
fi
