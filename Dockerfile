FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copia TODO el proyecto primero
COPY . .

# Instala Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Instala Node
RUN npm install

EXPOSE 9000

CMD ["php-fpm"]

