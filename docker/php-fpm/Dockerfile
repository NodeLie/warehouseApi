# PHP-FPM with Composer
FROM php:8.2-fpm

WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpq-dev \
    libzip-dev \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Set up non-root user
ARG PUID=1000
ARG PGID=1000
RUN usermod -u $PUID www-data && groupmod -g $PGID www-data

COPY --chown=www-data:www-data . /var/www
RUN composer install

# Set permissions
RUN chmod -R u+rwx /var/www

USER www-data

CMD ["php-fpm"]
