FROM php:8.2-fpm
WORKDIR "/test"

ENV NODE_OPTIONS="--openssl-legacy-provider"

ARG APCU_VERSION=5.1.22

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -o /usr/local/bin/cachetool http://gordalina.github.io/cachetool/downloads/cachetool.phar

RUN apt-get update && apt-get install -y --allow-downgrades \
    libfreetype6-dev \
    zlib1g-dev \
    libicu-dev \
    libzip-dev \
    libxml2-dev \
    libpq-dev \
    git \
    unzip

RUN pecl install apcu-${APCU_VERSION} && docker-php-ext-install -j$(nproc) iconv pdo pdo_mysql zip exif \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable opcache \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql
