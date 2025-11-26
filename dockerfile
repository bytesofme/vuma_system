FROM php:8.2-apache

WORKDIR /var/www/html

# Copy all project files
COPY . .

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite and point to correct directory
RUN a2enmod rewrite

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Create .htaccess for routing
RUN echo 'RewriteEngine On' > .htaccess
RUN echo 'RewriteCond %{REQUEST_FILENAME} !-f' >> .htaccess
RUN echo 'RewriteCond %{REQUEST_FILENAME} !-d' >> .htaccess
RUN echo 'RewriteRule ^(.*)$ index.php [QSA,L]' >> .htaccess

EXPOSE 8080

# Start Apache server
CMD ["apache2-foreground"]
