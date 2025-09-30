# Imagen base con PHP y Apache
FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar archivos de tu app al contenedor
COPY . /var/www/html/

# Copiar certificado SSL para conexión con Aiven
COPY config/ca.pem /etc/ssl/certs/ca.pem

# Habilitar mod_rewrite en Apache
RUN a2enmod rewrite

# Configurar Apache para escuchar el puerto asignado por Render
RUN echo "Listen ${PORT}" > /etc/apache2/ports.conf

# Exponer ese puerto
EXPOSE ${PORT}

# Comando de inicio
CMD ["apache2-foreground"]
