FROM marciodojr/phpstart-apache-docker-image:1.0.0
WORKDIR /srv/vhosts/phpApp
RUN composer install --no-ansi --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader \
&& php vendor/bin/doctrine orm:generate-proxies

COPY .docker/php/php-ini-overrides.ini /etc/php/7.2/apache2/conf.d/99-overrides.ini
COPY .docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN service apache2 restart
