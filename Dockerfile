FROM php:8.4-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git unzip \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zlib1g-dev \
    && docker-php-ext-install \
        pdo pdo_mysql intl zip opcache mbstring xml

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN COMPOSER_MEMORY_LIMIT=-1 composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts

COPY . .

RUN mkdir -p var/cache var/log \
    && chown -R www-data:www-data var

CMD ["php-fpm"]