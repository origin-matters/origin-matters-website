FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    ca-certificates

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Configure PHP
COPY php.ini /usr/local/etc/php/

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock* ./

# Install dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copy application files
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set SMTP environment variables
ENV SMTP_SERVER=smtp.hostinger.com
ENV SMTP_PORT=587
ENV SMTP_USERNAME=rameez.bhat@lockular.in 
ENV SMTP_PASSWORD='app-sepcific-password-here'
ENV RECIEVER=nick.evans@originmatters.co
EXPOSE 80

# Use the default Apache entrypoint

