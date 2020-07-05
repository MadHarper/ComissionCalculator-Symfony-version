FROM php:7.4-fpm-alpine

RUN apk update && apk add unzip


#RUN docker-php-ext-install imap
RUN docker-php-ext-install bcmath
RUN apk add postgresql-dev mysql-dev
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install opcache
RUN docker-php-ext-install exif
#RUN docker-php-ext-install intl

RUN apk add freetype-dev libjpeg-turbo-dev libpng-dev
RUN docker-php-ext-configure gd --with-freetype=/usr --with-jpeg=/usr \
    && docker-php-ext-install -j "$(nproc)" gd
#RUN apk add imagemagick imagemagick-libs imagemagick-dev
#RUN pecl install imagick



RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
COPY conf.d /usr/local/etc/php/conf.d

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet


WORKDIR /app
