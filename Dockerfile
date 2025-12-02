FROM php:8.4-fpm

ARG NODE_VERSION=24

# Połączone apt-get update i install dla lepszej optymalizacji warstw
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libwebp-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    sqlite3 \
    libsqlite3-dev \
    pkg-config \
    gnupg \
    wget \
    tar \
    build-essential \
    && rm -rf /var/lib/apt/lists/*

RUN pecl channel-update pecl.php.net \
    && (pecl list installed xdebug > /dev/null 2>&1 || pecl install xdebug) \
    && docker-php-ext-enable xdebug \
    && rm -rf /tmp/pear

RUN curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g less less-plugin-clean-css

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install -j$(nproc) \
    gd \
    intl \
    pdo_sqlite

WORKDIR /var/www/html