#!/bin/sh

printf "Starting nginx...\n\n"
nginx -g "daemon on;"

printf "Yarn install dependencies...\n\n"
yarn install

printf "Building mode Staging...\n\n"
yarn build:stage