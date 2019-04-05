#!/bin/sh

printf "Starting nginx...\n\n"
nginx -g "daemon on;"

printf "Yarn install dependencies...\n\n"
yarn install

printf "Building and watching app...\n\n"
yarn build-dev

printf "Ready to Development..\n\n"
