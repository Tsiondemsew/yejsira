FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && \
    apt-get install -y \
        unzip \
        zip \
        git \
        curl \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl opcache && \
    a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Create necessary directories first with proper permissions
RUN mkdir -p storage/framework/{sessions,views,cache} && \
    mkdir -p bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies (skip scripts for now)
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts

# Copy the rest of the application
COPY . .

# Set permissions again (in case copy changed them)
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Now run the composer scripts
RUN composer run-script post-autoload-dump

# Optimize Laravel
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Configure Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -i -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf && \
    sed -i -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80