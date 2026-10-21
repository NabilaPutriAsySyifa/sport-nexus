# Dockerfile for Sport Nexus (PHP 8.1 + Apache + CodeIgniter 3)
FROM php:8.1-apache

# 1. Install required PHP extensions for MySQL & image processing
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# 2. Enable Apache mod_rewrite for CodeIgniter clean URLs (.htaccess)
RUN a2enmod rewrite

# 3. Configure Document Root & AllowOverride All
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/override.conf \
    && a2enconf override

# 4. Copy application source code
COPY . /var/www/html/

# 5. Set proper permissions for cache, logs, and uploads
RUN chmod -R 777 /var/www/html/application/cache /var/www/html/application/logs /var/www/html/uploads

# 6. Expose default HTTP port
EXPOSE 80

# 7. Start Apache server
CMD ["apache2-foreground"]
