# 1. Base image PHP con FPM e estensioni comuni per Laravel
FROM php:8.2-fpm

# 2. Install dependencies di sistema
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Imposta working directory
WORKDIR /var/www/html

# 5. Copia il progetto
COPY . .

# 6. Installa le dipendenze PHP
RUN composer install --no-dev --optimize-autoloader

# 7. Imposta permessi per storage e cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Espone porta (Render la assegnerà a $PORT)
EXPOSE 8000

# 9. Comando per avviare Laravel
CMD php artisan serve --host 0.0.0.0 --port 8000
