FROM php:7.2-fpm

RUN apt-get -qq update &&  apt-get -qq install -y \
    vim \
    git \
    zip \
    zlib1g-dev \
    sqlite3 \
    libpng-dev \
    libxml2-dev \
 && rm -rf /var/lib/apt/lists/*

RUN  apt-get update && apt-get install && \
     pecl install uopz xdebug-2.6.1 && \
     docker-php-ext-enable uopz xdebug \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    mbstring \
    tokenizer \
    bcmath \
    pcntl \
    soap

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer
WORKDIR /var/www

ADD config/php.ini /usr/local/etc/php/php.ini

RUN adduser --disabled-password --gecos "" docker-user && \
  echo "docker-user ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

USER docker-user
