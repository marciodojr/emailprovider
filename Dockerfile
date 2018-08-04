FROM node:10.6.0-alpine  as frontendDependencies

COPY . /srv/vhosts/phpApp
WORKDIR /srv/vhosts/phpApp
RUN npm install grunt-cli -g && npm install && grunt build

FROM marciodojr/phpstart-apache-docker-image:1.0.0
WORKDIR /srv/vhosts/phpApp
COPY --from=frontendDependencies /srv/vhosts/phpApp /srv/vhosts/phpApp
RUN rm node_modules -rf \
&& composer install --no-ansi --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader \
&& php vendor/bin/doctrine orm:generate-proxies

COPY .docker/php/php-ini-overrides.ini /etc/php/7.2/apache2/conf.d/99-overrides.ini
COPY .docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN service apache2 restart
