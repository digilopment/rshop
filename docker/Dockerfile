FROM ubuntu:22.04

# Build-time arguments
ARG VERSION
ARG CONFIG
ARG PHP_VERSION

ENV VERSION=${VERSION}
ENV CONFIG=${CONFIG}
ENV PHP_VERSION=${PHP_VERSION}
ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    software-properties-common \
    git \
    unzip \
    curl \
    nano \
    gnupg \
    lsb-release \
    && rm -rf /var/lib/apt/lists/*

RUN add-apt-repository ppa:ondrej/php -y && apt-get update && apt-get install -y \
    php${PHP_VERSION} \
    php${PHP_VERSION}-cli \
    php${PHP_VERSION}-fpm \
    php${PHP_VERSION}-bcmath \
    php${PHP_VERSION}-dev \
    php${PHP_VERSION}-mysql \
    php${PHP_VERSION}-gd \
    php${PHP_VERSION}-intl \
    php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-xml \
    php${PHP_VERSION}-zip \
    php${PHP_VERSION}-soap \
    php${PHP_VERSION}-gmp \
    php${PHP_VERSION}-curl \
    php${PHP_VERSION}-sqlite3 \
    php${PHP_VERSION}-redis \
    php${PHP_VERSION}-imap \
    php${PHP_VERSION}-common \
    nginx \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
RUN git clone --branch ${VERSION} --single-branch https://github.com/digilopment/rshop.git app

WORKDIR /var/www/app

RUN composer install --no-interaction --prefer-dist --optimize-autoloader
COPY ./${CONFIG} /var/www/app/config/app_local.php

RUN rm /etc/nginx/sites-enabled/default
COPY ./nginx.conf /etc/nginx/sites-enabled/rshop.conf

RUN mkdir -p /var/www/app/mnt/ && touch /var/www/app/mnt/rshop.sqlite

RUN chown -R www-data:www-data /var/www/app/tmp /var/www/app/logs /var/www/app/mnt
RUN chmod 0777 -R /var/www/app/webroot /var/www/app/mnt /var/www/app/mnt

EXPOSE 80

CMD bash -c "\
  service php${PHP_VERSION}-fpm start && \
  bin/cake migrations migrate && \
  nginx -g 'daemon off;' \
"