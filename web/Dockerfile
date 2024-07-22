# Use a base image with PHP and Apache
FROM php:apache

# Install necessary PHP extensions and tools
RUN apt-get update && \
    apt-get install -y \
        git \
        libzip-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install additional PHP extensions
RUN docker-php-ext-install mysqli pdo_mysql zip

# Copy website files
COPY ./www /var/www/html/

# Set PHP configuration options
RUN echo "post_max_size = 50M" >> /usr/local/etc/php/php.ini && \
    echo "upload_max_filesize = 50M" >> /usr/local/etc/php/php.ini && \
    echo "max_execution_time = 0" >> /usr/local/etc/php/php.ini

# Change owner of the html folder to www-data
RUN chown -R www-data:www-data /var/www/html

# Expose ports
EXPOSE 80
EXPOSE 443


