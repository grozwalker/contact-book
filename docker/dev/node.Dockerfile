FROM node:10-alpine

RUN apk add --no-cache bash
RUN npm install --global gulp-cli @vue/cli

WORKDIR /var/www/
