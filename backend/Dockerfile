FROM node:10.16-alpine as build

# Create app folder
RUN mkdir /app
WORKDIR /app

# Install git, nginx, nano, bash
RUN apk update && apk upgrade && \
	apk add --no-cache git nginx bash nano

# Copy all files to app folder
COPY . /app

# Add configuration files
COPY image-files/ /
RUN chmod 700 /usr/local/bin/docker-entrypoint.sh

# Install app dependencies
RUN yarn install

# Build app
ARG NODE_ENV
ARG VUE_APP_BASE_API
ARG VUE_APP_VERSION
ARG VUE_APP_GOOGLE_API_KEY
ENV NODE_ENV $NODE_ENV
ENV VUE_APP_BASE_API $VUE_APP_BASE_API
ENV VUE_APP_VERSION $VUE_APP_VERSION
ENV VUE_APP_GOOGLE_API_KEY $VUE_APP_GOOGLE_API_KEY

RUN yarn build

# Expose port 80
EXPOSE 80
ENTRYPOINT ["docker-entrypoint.sh"]
