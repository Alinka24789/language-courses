FROM php:7.2.8-fpm-stretch

# update current state
RUN apt update && apt install -y --no-install-recommends apt-utils

# install extensions
RUN apt update \
    && apt install -y -f apt-transport-https \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libpq-dev \
    libfontconfig \
    ssmtp \
    snmp \
    acl \
    git \
    zip \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && docker-php-ext-install \
    exif \
    gd \
    intl \
    mbstring \
    opcache \
    mysqli \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    zip \
    && apt-get clean

COPY . /var/www/courses

RUN apt-get update && apt-get -y dist-upgrade
RUN apt-get -y install nginx openssl ca-certificates
RUN apt-get -y install cron

ADD docker/default.conf /etc/nginx/conf.d/default.conf
ADD docker/nginx.conf /etc/nginx/nginx.conf

VOLUME ["/etc/nginx"]
VOLUME ["/var/www"]

WORKDIR /var/www/courses

# replace shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh

ENTRYPOINT ["sh", "/var/www/courses/entrypoint.sh"]
