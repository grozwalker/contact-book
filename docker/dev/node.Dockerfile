FROM node:10-alpine

RUN npm install --global gulp-cli @vue/cli

WORKDIR /var/www/
