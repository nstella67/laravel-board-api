FROM php:8.2-fpm

# 필수 확장 설치
RUN docker-php-ext-install pdo pdo_mysql

# Composer 설치
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
