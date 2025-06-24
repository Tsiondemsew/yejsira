#!/usr/bin/env bash
composer install --no-interaction --prefer-dist
php artisan config:cache
php artisan migrate --force
