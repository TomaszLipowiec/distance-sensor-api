FROM phpdockerio/php:8.2-fpm
WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    php-intl \
    php8.2-redis \
    php8.2-pgsql \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get update \
    && apt-get install -y libicu-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer selfupdate

COPY . /var/www/html

COPY ./phpdocker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

RUN php -d error_reporting=24575
RUN composer install && php bin/console cache:clear

EXPOSE 8000
