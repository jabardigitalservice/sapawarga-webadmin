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

# Expose port 80
EXPOSE 80
ENTRYPOINT ["docker-entrypoint.sh"]
