FROM ubuntu:22.04

ARG VERSION
ENV VERSION=${VERSION}
ENV DEBIAN_FRONTEND=noninteractive

# Update & základné balíky
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
    php8.1 \
    php8.1-cli \
    php8.1-fpm \
    php8.1-bcmath \
    php8.1-dev \
    php8.1-mysql \
    php8.1-gd \
    php8.1-intl \
    php8.1-mbstring \
    php8.1-xml \
    php8.1-zip \
    php8.1-soap \
    php8.1-gmp \
    php8.1-curl \
    php8.1-sqlite3 \
    php8.1-redis \
    php8.1-imap \
    php8.1-common \
    nginx \
    && rm -rf /var/lib/apt/lists/*


# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Klon repozitára
WORKDIR /var/www
RUN git clone --branch ${VERSION} --single-branch https://github.com/digilopment/rshop.git app

WORKDIR /var/www/app

# Composer install
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
COPY ./app_local.php /var/www/app/config/app_local.php

# Konfigurácia nginx
RUN rm /etc/nginx/sites-enabled/default
COPY ./nginx.conf /etc/nginx/sites-enabled/rshop.conf

# Nastavenie práv
RUN chown -R www-data:www-data /var/www/app/tmp /var/www/app/logs

# Expose porty
EXPOSE 80

# Spustenie všetkého
CMD bash -c "\
  service php8.1-fpm start && \
  bin/cake migrations migrate && \
  nginx -g 'daemon off;' \
"

