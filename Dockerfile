FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    librdkafka-dev \
    && docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org | php && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

COPY composer.json ./
RUN composer install --no-interaction

COPY ./www /var/www/html

CMD ["php-fpm"]
