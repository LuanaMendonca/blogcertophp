FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    nano \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
