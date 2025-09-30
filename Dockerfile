FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql
COPY . /var/www/html/
RUN a2enmod rewrite

# Cambia DocumentRoot y Apache config
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
 && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Permitir .htaccess y directorios
RUN echo "<Directory /var/www/html/public>\n\tOptions Indexes FollowSymLinks\n\tAllowOverride All\n\tRequire all granted\n</Directory>" \
>> /etc/apache2/apache2.conf \
 && echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

# Puerto
RUN echo "Listen 8080" > /etc/apache2/ports.conf
ENV APACHE_RUN_PORT=8080

EXPOSE 8080

CMD ["apache2-foreground"]
