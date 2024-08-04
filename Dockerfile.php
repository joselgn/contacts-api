FROM php:8.2-apache

LABEL MAINTAINER="Jose Carlos Fernandes <joselgn@gmail.com>"

ENV TZ=America/Sao_Paulo

RUN apt-get update && \  
    apt-get install -y vim wget curl git \
    libfreetype-dev libjpeg62-turbo-dev libpng-dev libpq-dev libonig-dev libzip-dev \
    zip unzip make

RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd bcmath

RUN pecl install xdebug

RUN pecl install redis

RUN docker-php-ext-enable pdo_mysql mbstring exif pcntl bcmath gd redis xdebug

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

RUN echo "[xdebug]" >> /usr/local/etc/php/php.ini && \
#    echo "zend_extension = /usr/lib64/php/modules/xdebug.so" >> /usr/local/etc/php/php.ini && \
    echo "xdebug.mode=debug" >> /usr/local/etc/php/php.ini && \
    echo "debug.client_host=127.0.0.1" /usr/local/etc/php/php.ini && \
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/php.ini && \
    echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/php.ini && \
    echo "xdebug.log=/var/log/xdebug.log" >> /usr/local/etc/php/php.ini && \
    #echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/php.ini && \
    echo "xdebug.client_port=9003" >> /usr/local/etc/php/php.ini

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's!AllowOverride None!AllowOverride All!g' /etc/apache2/sites-available/000-default.conf 

RUN a2enmod rewrite

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && HASH="$(wget -q -O - https://composer.github.io/installer.sig)" \
 && php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
 && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

RUN echo $TZ > /etc/timezone

EXPOSE 80