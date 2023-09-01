# Use the official PHP image as the base image
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && npm install npm@8.19.2 -g

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-scripts --no-autoloader

# Copy the rest of the application
COPY . .

# Generate optimized autoload files
RUN composer dump-autoload --optimize

# Install NodeJS dependencies and build vite
RUN npm i
RUN npm run build

# Expose port
EXPOSE 8000

# Start PHP-FPM server
CMD ["php-fpm"]
