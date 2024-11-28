#!/bin/sh

if [ ! -d /app/vendor ]; then
    echo "Running composer install..."
    composer install --no-interaction --optimize-autoloader
fi

# Clear and cache Laravel config
php /app/src/artisan config:cache

# Run Laravel migrations with force
php /app/src/artisan migrate --force

# Start Supervisor to manage background processes
/usr/bin/supervisord -c /etc/supervisor/supervisord.conf

# Replace LISTEN_PORT in nginx.conf
sed -i "s,LISTEN_PORT,8080,g" /etc/nginx/nginx.conf

# Start PHP-FPM
php-fpm -D

# Wait for PHP-FPM to be ready (on port 9000)
while ! nc -w 1 -z 0.0.0.0 9000; do 
    sleep 0.1
done

# Start Nginx to serve the application
nginx