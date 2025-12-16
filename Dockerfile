FROM php:8.2-fpm

# System deps
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project
COPY . .

# PHP deps
RUN composer install --no-dev --optimize-autoloader

# Frontend deps + build
RUN npm install
RUN npm run build

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache public/build

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
