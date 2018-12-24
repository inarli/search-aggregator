FROM php:7.1.14-cli

RUN apt-get update
RUN apt-get install --no-install-recommends -y git-core unzip
RUN pecl install xdebug-2.5.0 && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app