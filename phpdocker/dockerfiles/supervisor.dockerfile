FROM phpdockerio/php:8.2-fpm
WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y \
    supervisor  \
    php8.2-pdo \
    php8.2-pgsql

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt-get update && \
    apt-get install -y \ 
    symfony-cli

COPY ./phpdocker/supervisor/supervisord.conf /etc/supervisor/conf.d/ai-hub.conf

EXPOSE 8000
CMD ["/usr/bin/supervisord"]