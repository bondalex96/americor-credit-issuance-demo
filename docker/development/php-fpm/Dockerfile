FROM php:8.3.13-fpm-alpine3.20

RUN apk add --no-cache --update \
        acl \
        autoconf \
        fcgi \
        file \
        g++ \
        gettext \
        git \
        gnu-libiconv \
        icu \
        icu-dev \
        libzip \
        libzip-dev \
        make \
        openssl \
        rabbitmq-c  \
        rabbitmq-c-dev \
        zlib-dev \
        supervisor \
        openssh-server \
        openssh-client \
        linux-headers \
    && pecl install amqp-1.11.0 xdebug \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable amqp xdebug

COPY ./docker/development/php-fpm/xdebug.ini /usr/local/etc/php/conf.d

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /root/.composer/cache
RUN composer --version

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql intl zip

WORKDIR /app

ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"

RUN adduser --uid 1000 --disabled-password userapp

RUN mkdir -p /home/userapp/.composer \
   && chown -R userapp /home/userapp/.composer \
   && chgrp -R userapp /home/userapp/.composer

USER userapp
