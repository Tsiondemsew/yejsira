# Use official PHP image
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    zip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    sqlite3 \
    libsqlite3-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite mbstring zip exif pcntl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy all files
COPY . .

# Install PHP dependencies
RUN composer install

# Generate Laravel key
RUN php artisan key:generate

# Expose port
EXPOSE 8000

# Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
