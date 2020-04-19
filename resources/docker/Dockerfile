FROM php:7.4-fpm

SHELL ["/bin/bash", "-c"]
RUN apt-get update && apt-get install -y \
        wget \
        zip \
        vim \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && pecl install xdebug redis \
    && echo -e "\
zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so) \n\
xdebug.remote_enable=on \n\
xdebug.remote_autostart=off \n\
xdebug.remote_port=9001 \n\
xdebug.remote_handler=dbgp \n\
xdebug.remote_connect_back=0 \n\
xdebug.idekey=xdebug \n\
xdebug.remote_host=docker.for.mac.localhost \n\
xdebug.extended_info=1 \n\
    " >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo -e "\
#    extension=mysqli.so \n\
#    " >> /usr/local/etc/php/conf.d/docker-php-ext-mysqli.ini \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /tmp/*

EXPOSE 8000
EXPOSE 9000

CMD php artisan serve --host=0.0.0.0