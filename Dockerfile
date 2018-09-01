FROM portus.egame.vn/ci/nginx-php:php71

WORKDIR /src

##Install JDK8
RUN apt-get update -y \
    && apt-get install openjdk-8-jdk -y \
    && apt-get autoclean \
    && rm -vrf /var/lib/apt/lists/*.* /tmp/* /var/tmp/*

## Add custom service to supervisor
COPY docker/supervisor/conf.d/ /etc/supervisor/conf.d/
RUN grep -q include /etc/supervisord.conf \
    || echo -e "[include]\nfiles = /etc/supervisor.d/*.conf\n" >> /etc/supervisord.conf

COPY composer.* ./
RUN composer update --no-scripts --no-autoloader --no-ansi

COPY . ./
RUN composer dump-autoload --optimize \
    && touch  /src/storage/logs/lumen.log \
    && chown -R www-data: /src \
    && chmod -R 777 /src/storage /src/bootstrap/cache
