FROM php:8.2-apache

WORKDIR /var/www/html

# Copy all project files
COPY . .

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite headers

# Configure Apache to serve CSS/JS files properly
RUN echo '<Directory /var/www/html>' > /etc/apache2/conf-available/custom.conf
RUN echo '    Options Indexes FollowSymLinks' >> /etc/apache2/conf-available/custom.conf
RUN echo '    AllowOverride All' >> /etc/apache2/conf-available/custom.conf
RUN echo '    Require all granted' >> /etc/apache2/conf-available/custom.conf
RUN echo '    <FilesMatch "\.(css|js|png|jpg|jpeg|gif|ico|svg)$">' >> /etc/apache2/conf-available/custom.conf
RUN echo '        Header set Cache-Control "max-age=86400"' >> /etc/apache2/conf-available/custom.conf
RUN echo '    </FilesMatch>' >> /etc/apache2/conf-available/custom.conf
RUN echo '</Directory>' >> /etc/apache2/conf-available/custom.conf

RUN a2enconf custom

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

EXPOSE 8080

# Start Apache server
CMD ["apache2-foreground"]
