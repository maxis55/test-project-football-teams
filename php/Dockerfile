FROM php:8.2-fpm-alpine


# Install extensions

RUN docker-php-ext-install pdo pdo_mysql


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# www-data default user for php-fpm
RUN chown -R www-data:www-data /var/www


# Might be needed if other command is not working
#RUN chmod -R 777 /var/www/storage

# Set working directory
WORKDIR /var/www
