FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

# Update & základné balíky
RUN apt-get update && apt-get install -y \
    software-properties-common \
    git \
    unzip \
    curl \
    gnupg \
    lsb-release \
    && rm -rf /var/lib/apt/lists/*

RUN add-apt-repository ppa:ondrej/php -y && apt-get update && apt-get install -y \
    php8.1 \
    php8.1-cli \
    php8.1-common \
    php8.1-fpm \
    php8.1-mysql \
    php8.1-intl \
    php8.1-xml \
    php8.1-mbstring \
    php8.1-curl \
    php8.1-zip \
    php8.1-gd \
    nginx \
    mysql-server \
    && rm -rf /var/lib/apt/lists/*

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Klon repozitára
WORKDIR /var/www
RUN git clone https://github.com/digilopment/rshop.git app
WORKDIR /var/www/app

# Composer install
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Konfigurácia nginx
RUN rm /etc/nginx/sites-enabled/default
COPY ./nginx.conf /etc/nginx/sites-enabled/rshop.conf

# Nastavenie práv
RUN chown -R www-data:www-data /var/www/app/tmp /var/www/app/logs

# Expose porty
EXPOSE 80 3306

# Spustenie všetkého
CMD service mysql start && service php8.2-fpm start && nginx -g 'daemon off;'
