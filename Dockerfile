FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html/

COPY config/ca.pem /etc/ssl/certs/ca.pem

RUN a2enmod rewrite

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

RUN echo "Listen 8080" > /etc/apache2/ports.conf
ENV APACHE_RUN_PORT=8080

# ⚠️ Permisos y AllowOverride
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

EXPOSE 8080

CMD ["apache2-foreground"]
