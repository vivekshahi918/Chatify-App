# Dockerfile
FROM php:8.2-apache

# Copy application code into Apache web root
COPY . /var/www/html/

# Install mysqli extension for PHP
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev zip \
 && docker-php-ext-install mysqli \
 && docker-php-ext-enable mysqli \
 && rm -rf /var/lib/apt/lists/*

# Expose port 80 for web traffic
EXPOSE 80
