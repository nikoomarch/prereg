FROM php:7.3-fpm
RUN apt-get update && apt-get install -y libmcrypt-dev mysql-client \
    && pecl install mcrypt-1.0.2 \
    && docker-php-ext-enable mcrypt\
    && docker-php-ext-install pdo_mysql mysqli
WORKDIR /var/www