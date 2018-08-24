FROM portus.egame.vn/ci/nginx-php:php71

WORKDIR /src

COPY composer.* ./
RUN composer update --no-scripts --no-autoloader --no-ansi

COPY . ./
RUN composer dump-autoload --optimize \
    && touch  /src/storage/logs/lumen.log \
    && chown -R www-data: /src