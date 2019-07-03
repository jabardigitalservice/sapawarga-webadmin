#################################
# Production
#################################
FROM node:10.1-alpine as build

# Create app folder
RUN mkdir /app
WORKDIR /app

RUN apk update && apk upgrade && \
	apk add --no-cache git

RUN npm install -g yarn && \
	chmod a+rwx /usr/local/lib/node_modules/yarn/bin/yarn* && \
	chmod a+rwx  /usr/local/bin/yarn* && \
	yarn global add @vue/cli

# Copy package*.json to app folder
COPY package.json yarn.lock /app/

# Install app dependencies
RUN yarn install

# Copy all files to app folder
COPY . /app

# Build the app
RUN yarn build

# Add configuration files
COPY image-files/ /
RUN chmod 700 /usr/local/bin/docker-entrypoint.sh

# Install nginx, nano, bash, and python
RUN apk --update add nginx bash nano python

# Expose port 80
EXPOSE 80
ENTRYPOINT ["docker-entrypoint.sh"]
