FROM php:7.4-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libssh-dev librabbitmq-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql zip bcmath sockets \
    && pecl install apcu \
    && pecl install amqp \
    && docker-php-ext-enable apcu amqp \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN git config --global user.email "ahlesswywk@gmail.com" \
    && git config --global user.name "Alexander Garuba"