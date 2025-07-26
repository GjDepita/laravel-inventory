#!/bin/bash

# Run Laravel migrations or setup if needed
composer install

# Clear caches just in case
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run Laravel dev server in background
php artisan serve --host=0.0.0.0 --port=8000 &

# Run Vite
npm run dev
