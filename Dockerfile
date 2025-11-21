# Use PHP 8.0.30 FPM
FROM php:8.0.30-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies + MariaDB
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    mariadb-server \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd \
    && apt-get clean

# Install Composer 2.8.12
RUN curl -sS https://getcomposer.org/installer | php -- --version=2.8.12 --install-dir=/usr/local/bin --filename=composer

# Copy project files
COPY . .

# Copy database SQL file
COPY db/seghis_patient_portal.sql /docker-entrypoint-initdb.d/seghis_patient_portal.sql

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose ports for Laravel and MariaDB
EXPOSE 10000 3306

# Environment variables for MariaDB
ENV DB_ROOT_PASSWORD=rootpassword
ENV DB_USERNAME=seghis_user
ENV DB_PASSWORD=seghis_pass
ENV DB_NAME=seghis_patient_portal

# Start MariaDB and Laravel server
CMD service mysql start && \
    mysql -u root -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME};" && \
    mysql -u root -e "CREATE USER IF NOT EXISTS '${DB_USERNAME}'@'%' IDENTIFIED BY '${DB_PASSWORD}';" && \
    mysql -u root -e "GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USERNAME}'@'%'; FLUSH PRIVILEGES;" && \
    mysql -u ${DB_USERNAME} -p${DB_PASSWORD} ${DB_NAME} < /docker-entrypoint-initdb.d/seghis_patient_portal.sql && \
    php -S 0.0.0.0:10000 -t public
