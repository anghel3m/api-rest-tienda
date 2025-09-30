FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html/

RUN a2enmod rewrite

# Deja DocumentRoot sin cambios (default es /var/www/html)
# Opcional: asegúrate de que el DocumentRoot en Apache config esté bien
RUN sed -i 's|DocumentRoot /var/www/html/public|DocumentRoot /var/www/html|g' /etc/apache2/sites-available/000-default.conf \
 && sed -i 's|DocumentRoot /var/www/html/public|DocumentRoot /var/www/html|g' /etc/apache2/apache2.conf

# Permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Permitir .htaccess y directorios en la raíz
RUN echo "<Directory /var/www/html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
DirectoryIndex index.php index.html
" >> /etc/apache2/apache2.conf

RUN echo "Listen 8080" > /etc/apache2/ports.conf
ENV APACHE_RUN_PORT=8080

EXPOSE 8080

CMD ["apache2-foreground"]
