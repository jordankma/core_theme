FROM portus.egame.vn/ci/nginx-php:php71

WORKDIR /src

##Install JDK8
#RUN apt-get update -y \
#    && apt-get install openjdk-8-jdk -y \
#    && apt-get autoclean \
#    && rm -vrf /var/lib/apt/lists/*.* /tmp/* /var/tmp/*

## Add custom service to supervisor
COPY docker/supervisor/conf.d/ /etc/supervisor/conf.d/
COPY docker/nginx/nginx.conf /etc/nginx/

## Modify php config
RUN sed -i 's/.*upload_max_filesize.*/upload_max_filesize = 200M/g' /etc/php/7.1/fpm/php.ini
RUN sed -i 's/.*post_max_size.*/post_max_size = 200M/g' /etc/php/7.1/fpm/php.ini

#RUN echo "[include]" >> /etc/supervisord.conf \
#    && echo "files = /etc/supervisor/conf.d/*.conf" >> /etc/supervisord.conf

COPY composer.* ./
RUN composer update --no-scripts --no-autoloader --no-ansi

COPY . ./
RUN composer dump-autoload --optimize

## Path XSS
COPY patch/vendor/ ./vendor/

## Fix permission
RUN touch  /src/storage/logs/lumen.log \
    && chown -R www-data: /src \
    && chmod -R 777 /src/storage /src/bootstrap/cache

