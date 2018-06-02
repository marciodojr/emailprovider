FROM php:7.2-apache

RUN apt-get update -y && apt-get install -y libxml2-dev libcurl4-gnutls-dev curl

RUN docker-php-ext-install mysqli pdo_mysql mbstring xml dom curl

LABEL authors="Márcio Dias"

COPY . /srv/vhosts/phpApp
RUN rm /srv/vhosts/phpApp/.docker -rf

WORKDIR /srv/vhosts/phpApp

# virtualhost config
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
# enables virtualhost
RUN chown -R www-data:www-data /srv/vhosts/phpApp && a2enmod rewrite && a2enmod expires && service apache2 restart
