# build stage
FROM node:12.16-alpine as build


ARG VUE_APP_BASE_API 
ARG SENTRY_DSN_API 
ARG GOOGLE_MAPS_WEB_API_KEY 
ARG VUE_APP_PHONE 
ARG VUE_APP_ANALYTICS_ID 
ARG VUE_APP_S3_URL 
ARG VUE_APP_ERROR_ENVIRONMENT

ENV VUE_APP_BASE_API=${VUE_APP_BASE_API}
ENV SENTRY_DSN_API=${SENTRY_DSN_API}
ENV GOOGLE_MAPS_WEB_API_KEY=${GOOGLE_MAPS_WEB_API_KEY}
ENV VUE_APP_PHONE=${VUE_APP_PHONE}
ENV VUE_APP_ANALYTICS_ID=${VUE_APP_ANALYTICS_ID}
ENV VUE_APP_S3_URL=${VUE_APP_S3_URL}
ENV VUE_APP_ERROR_ENVIRONMENT=${VUE_APP_ERROR_ENVIRONMENT}

RUN mkdir /app
COPY . /app
WORKDIR /app/backend

RUN apk update && apk upgrade && \
	apk add --no-cache git

RUN yarn install
RUN yarn global add @vue/cli && yarn build

# production stage
FROM nginx:1.21.0
COPY --from=build /app/backend/dist /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]