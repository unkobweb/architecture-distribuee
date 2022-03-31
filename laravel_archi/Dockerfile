FROM php:8.1.4-cli-bullseye

USER root

RUN apt update -y && apt upgrade -y
RUN apt install wget unzip -y
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN pecl install mongodb
RUN echo "extension=mongodb.so" >> "$PHP_INI_DIR/php.ini"

ADD . /app

WORKDIR /app

RUN wget -O composer-setup.php https://getcomposer.org/installer
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN composer install

CMD ["php","artisan","serve","--host=0.0.0.0", "--port=8000"]