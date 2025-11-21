# Use PHP 8.0.30 FPM
FROM php:8.0.30-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd \
    && apt-get clean

# Install Composer 2.8.12
RUN curl -sS https://getcomposer.org/installer | php -- --version=2.8.12 --install-dir=/usr/local/bin --filename=composer

# Copy project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port for Render
EXPOSE 10000

# Start Laravel server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
