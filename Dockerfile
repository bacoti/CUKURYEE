# Stage 1: Build assets dengan Node.js
FROM node:18 as node_assets
WORKDIR /app
COPY . .
RUN npm install
RUN npm run build

# Stage 2: Siapkan environment PHP
FROM php:8.2-fpm as php_fpm
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libpq-dev nodejs npm
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
COPY . .
COPY --from=node_assets /app/public /var/www/public
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache
RUN php artisan config:clear
RUN php artisan storage:link

# Stage 3: Setup Web Server Nginx
FROM nginx:alpine
WORKDIR /var/www
RUN rm /etc/nginx/conf.d/default.conf
COPY .docker/nginx.conf /etc/nginx/conf.d
COPY --from=php_fpm /var/www /var/www
CMD ["/bin/sh", "-c", "php-fpm & nginx -g \"daemon off;\""]
