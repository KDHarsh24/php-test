FROM php:8.1-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install PostgreSQL dependencies and Composer
RUN apt-get update && \
    apt-get install -y libpq-dev postgresql-client unzip curl && \
    docker-php-ext-install pdo pdo_pgsql


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Copy source files
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN composer install --no-interaction

# Apache document root to /var/www/html/public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Fix permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

EXPOSE 80

# Copy entrypoint script
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set the container entrypoint
ENTRYPOINT ["entrypoint.sh"]


