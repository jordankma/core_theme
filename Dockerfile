FROM linhngegroup/nginx-php

WORKDIR /src

COPY composer.* ./
RUN composer install --no-scripts --no-autoloader --no-ansi

COPY . ./
RUN composer dump-autoload --optimize \
    && touch  /src/storage/logs/lumen.log \
    && chown -R www-data: /src
