FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar código
COPY . /var/www/html/

# Copiar certificado SSL
COPY config/ca.pem /etc/ssl/certs/ca.pem

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar Apache en puerto 8080 (Render lo mapeará automáticamente)
RUN echo "Listen 8080" > /etc/apache2/ports.conf
ENV APACHE_RUN_PORT=8080

# Exponer el puerto
EXPOSE 8080

# Comando de inicio
CMD ["apache2-foreground"]
