# Imagen base con PHP y Apache
FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar archivos de tu app
COPY . /var/www/html/

# Habilitar mod_rewrite en Apache
RUN a2enmod rewrite

# Configurar Apache para usar el puerto de Render
RUN echo "Listen ${PORT}" > /etc/apache2/ports.conf

# Exponer el puerto
EXPOSE ${PORT}

# Iniciar Apache
CMD ["apache2-foreground"]
