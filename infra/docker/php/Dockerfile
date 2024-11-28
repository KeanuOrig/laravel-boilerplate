FROM php:8.4-fpm-alpine

WORKDIR /app

# timezone environment
ENV TZ=UTC \
  # locale
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  # composer environment
  COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.3 /usr/bin/composer /usr/bin/composer

# Install dependencies and tools in a single RUN command
RUN apk add --no-cache \
    bash \
    nginx \
    wget \
    oniguruma-dev \
    nano \
    gnupg \
    less \
    libpng-dev \
    libzip-dev \
    su-exec \
    unzip \
    supervisor

# Install PHP extensions
RUN docker-php-ext-install \
    bcmath \
    exif \
    mbstring \
    opcache \
    pdo \
    pdo_mysql \
    pcntl \
    gd \
    zip
    
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

COPY infra/docker/php/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

COPY ./src /app

# Set ownership to www-data (assuming 33:33 is the www-data user and group)
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache /app/storage/framework/views

# Ensure proper permissions for the directories
RUN chmod -R 777 /app/storage /app/bootstrap/cache /app/storage/framework/views

# Install Composer
RUN wget -q http://getcomposer.org/composer.phar && \
    chmod a+x composer.phar && \
    mv composer.phar /usr/local/bin/composer

RUN composer install
RUN chmod -R 777 storage bootstrap/cache 
RUN php artisan optimize:clear
RUN php artisan optimize
RUN echo "Build completed successfully!"
