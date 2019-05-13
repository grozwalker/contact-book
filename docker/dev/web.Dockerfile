FROM nginx:1.12

COPY ./docker/dev/config/backend.conf /etc/nginx/conf.d/backend.conf
COPY ./docker/dev/config/frontend.conf /etc/nginx/conf.d/frontend.conf

WORKDIR /var/www