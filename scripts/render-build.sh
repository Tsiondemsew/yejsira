#!/usr/bin/env bash
composer install --no-interaction --prefer-dist
php artisan config:cache 
# Run database migrations
php artisan migrate --force

# Clear cache
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Optimize
php artisan optimize