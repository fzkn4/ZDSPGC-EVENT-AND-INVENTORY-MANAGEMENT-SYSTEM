FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PDO MySQL and other PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Enable Apache modules
RUN a2enmod rewrite

# Configure Apache DocumentRoot
ENV APACHE_DOCUMENT_ROOT=/var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Allow .htaccess overrides
RUN printf "<Directory /var/www/html>\n    AllowOverride All\n    Require all granted\n</Directory>\n" > /etc/apache2/conf-available/project.conf \
    && a2enconf project

# Set working directory
WORKDIR /var/www/html

# Set proper permissions (will be set by volume mount, but good for COPY scenarios)
# RUN chown -R www-data:www-data /var/www/html \
#     && chmod -R 755 /var/www/html
