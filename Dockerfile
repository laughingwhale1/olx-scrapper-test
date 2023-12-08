# Use PHP with Apache as the base image
FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

WORKDIR /var/www

COPY . /var/www

COPY --chown=www-data:www-data . /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install project dependencies
RUN composer install

# Copy .env.example to .env
RUN cp .env.example .env


# Expose port 8000 and start php server
EXPOSE 8000
CMD docker compose up -d
CMD php artisan serve --host=127.0.0.1 --port=8000 & php artisan queue:work --queue=default
