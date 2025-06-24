# Use PHP 8.2 CLI image
FROM php:8.2-cli

    # Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \  # This is critical for PostgreSQL
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl opcache \
    && a2enmod rewrite

# Install required PHP extensions including PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Copy and setup .env
RUN cp .env.example .env

# Install dependencies
RUN composer install --no-interaction --prefer-dist

# Generate Laravel key
RUN php artisan key:generate

# Expose port
EXPOSE 8000

# Start Laravel app
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
