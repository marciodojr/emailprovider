# FROM php:7.2-apache

# LABEL authors="Márcio Dias"

# RUN apt-get update -y && apt-get install -y libxml2-dev libcurl4-gnutls-dev curl && pecl install redis && docker-php-ext-enable redis && docker-php-ext-install mysqli pdo_mysql mbstring xml dom curl

# COPY . /srv/vhosts/phpApp
# WORKDIR /srv/vhosts/phpApp

# RUN chown -R www-data:www-data /srv/vhosts/phpApp && a2enmod rewrite && a2enmod expires && a2enmod headers && service apache2 restart && rm /srv/vhosts/phpApp/.docker -rf

FROM php:7.2-fpm
WORKDIR "/srv/vhosts/phpApp"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update -y && apt-get install -y libxml2-dev libcurl4-gnutls-dev curl && pecl install redis && docker-php-ext-enable redis && docker-php-ext-install mysqli pdo_mysql mbstring xml dom curl
