FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

# Copiar código
COPY . /var/www/html/

# Copiar certificado SSL
COPY config/ca.pem /etc/ssl/certs/ca.pem

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar DocumentRoot en Apache a /var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Configurar Apache en puerto 8080
RUN echo "Listen 8080" > /etc/apache2/ports.conf
ENV APACHE_RUN_PORT=8080

EXPOSE 8080

CMD ["apache2-foreground"]
