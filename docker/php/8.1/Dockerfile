FROM php:8.1-fpm
WORKDIR /var/www/html

########## Install dependencies ##########

########## iran server for repos ##########
COPY sources.list-iran /etc/apt/sources.list

########## PROXY ##########
#ENV HTTP_PROXY="http://USER_NAME:PASS@192.168.1.191:10809"
RUN apt-get update --fix-missing -y \
        && apt-get upgrade -y \
        && apt-get install -y nano\
                              htop \
                              procps \
                              libpng-dev \
                              zlib1g-dev \
                              libonig-dev \
                              build-essential \
                              git \
                              curl \
                              libfreetype6-dev \
                              libjpeg62-turbo-dev \
                              libssl-dev \
                              libjpeg-dev \
                              libonig-dev \
                              libicu-dev


RUN apt-get install -y libcurl4-openssl-dev
RUN docker-php-ext-install curl
########## SSL ##########
RUN apt-get install -y --no-install-recommends openssl

######### Mysql client ######
RUN apt-get install -y default-mysql-client

######### Mysql gb ######
RUN docker-php-ext-install mbstring
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd


########## PHP zip ##########
RUN apt-get install -y --no-install-recommends libzip-dev unzip \
        && docker-php-ext-install zip

########## PHP exif ##########
RUN docker-php-ext-install exif


########## PHP bcmath ##########
RUN docker-php-ext-install bcmath


########## PHP pdo ##########
RUN docker-php-ext-install pdo pdo_mysql

########## PHP soap #########
RUN apt-get install -y \
     libxml2-dev \
     && docker-php-ext-install soap

########## Composer ##########
RUN mkdir /var/www/.composer \
        && chown www-data:www-data /var/www/.composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

######## ini ######
COPY php.ini ${PHP_INI_DIR}/php.ini
COPY opcache.ini ${PHP_INI_DIR}/conf.d/opcache.ini

########## PHP pcntl #########
RUN docker-php-ext-install pcntl
RUN apt-get install -y git
RUN apt-get install -y --no-install-recommends $PHPIZE_DEPS
COPY redis-5.3.7.tgz /var/php-extentions/redis-5.3.7.tgz
RUN pecl install /var/php-extentions/redis-5.3.7.tgz && docker-php-ext-enable redis
