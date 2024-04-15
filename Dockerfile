FROM php:8.3.3-bullseye as app

## Diretório da aplicação
ARG APP_DIR=/var/www/app

### apt-utils é um extensão de recursos do gerenciador de pacotes APT
RUN apt-get update -y && apt-get -y upgrade && apt-get install -y --no-install-recommends \
    apt-utils \
    nano \
    sqlite3 \
    libsqlite3-dev \
    libfreetype6-dev

# dependências recomendadas de desenvolvido para ambiente linux
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip \
    libpng-dev \
    libpq-dev \
    libxml2-dev

RUN docker-php-ext-configure gd --with-freetype
RUN docker-php-ext-install sockets pdo xml zip gd fileinfo

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR $APP_DIR
RUN cd $APP_DIR
RUN chown www-data:www-data $APP_DIR
COPY --chown=www-data:www-data ./app .

RUN composer install --no-interaction
RUN composer update --no-interaction
