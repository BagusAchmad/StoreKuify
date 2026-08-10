#!/bin/sh
set -e

# Ensure required directories exist
mkdir -p /run/nginx \
         /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/public/uploads

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/uploads
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/uploads

# Substitute $PORT into Nginx config (defaulting to 3000 if PORT is unset)
export PORT="${PORT:-3000}"
envsubst '$PORT' < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf

# Run Laravel optimizations
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start PHP-FPM in background and Nginx in foreground
php-fpm -D
exec nginx -g "daemon off;"
