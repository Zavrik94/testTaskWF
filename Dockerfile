FROM php:7.2-fpm

WORKDIR /var/www/html

# Install required packages and PHP modules
RUN apt-get update
RUN apt-get upgrade -y
RUN apt-get -y install --fix-missing apt-utils build-essential git curl libcurl3 zip vim

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Other PHP7 Extensions
RUN apt-get -y install libmcrypt-dev

# Install DB drivers
RUN apt-get -y install libsqlite3-dev libsqlite3-0 mysql-client libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql

# RUN docker-php-ext-install curl
RUN docker-php-ext-install tokenizer
RUN docker-php-ext-install json

# RUN apt-get -y install zlib1g-dev
# RUN docker-php-ext-install zip

RUN apt-get -y install libicu-dev
RUN apt-get -y install sendmail
RUN docker-php-ext-install -j$(nproc) intl

RUN docker-php-ext-install mbstring

# Install GD PHP extension with FreeType support for captcha support
RUN apt-get install -y libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
    libfreetype6-dev
RUN docker-php-ext-configure gd --with-gd --with-webp-dir --with-jpeg-dir \
    --with-png-dir --with-zlib-dir --with-xpm-dir --with-freetype-dir \
    --enable-gd-native-ttf
RUN docker-php-ext-install gd

# Copy the working dir to the image's web root
COPY . /var/www/html

# Fix write permissions with shared folders
#RUN a2enmod rewrite
RUN usermod -u 1000 www-data
