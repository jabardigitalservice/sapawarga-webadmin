FROM node:10.16-alpine as build

# Create app folder
RUN mkdir /app
WORKDIR /app

COPY backend/package*.json ./
RUN npm install
COPY . .
RUN npm run build

# production stage
FROM nginx:stable-alpine
COPY --from=build-stage /app/dist /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]