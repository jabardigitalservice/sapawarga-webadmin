FROM node:12.16-alpine as build

RUN mkdir /app
COPY . /app
WORKDIR /app/backend

RUN apk update && apk upgrade && \
	apk add --no-cache git


RUN yarn install
RUN yarn global add @vue/cli && yarn build

# production stage
FROM nginx:1.21.0
COPY --from=build /app/dist /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]