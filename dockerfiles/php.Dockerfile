FROM php:8.4-fpm-alpine

WORKDIR /var/www/laravel

RUN docker-php-ext-install pdo pdo_mysql

RUN chown -R www-data:www-data storage bootstrap/cache