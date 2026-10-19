# ==============================================================================
# Dockerfile - Panadería y Pastelería Pan y Queque ERP
# Entorno PHP 8.2 con Servidor Web Apache y MariaDB
# ==============================================================================

FROM php:8.2-apache

# Actualizar paquetes e instalar extensiones útiles para ERP y Base de Datos (MariaDB / MySQL)
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    mariadb-client \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mysqli zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilitar módulos de Apache requeridos (mod_rewrite para .htaccess y mod_headers)
RUN a2enmod rewrite headers

# Configuración personalizada de VirtualHost (DocumentRoot en /public)
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar el código fuente del proyecto
COPY . /var/www/html/

# Ajustar permisos para el usuario web de Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponer el puerto HTTP
EXPOSE 80

# Iniciar servidor Apache en primer plano
CMD ["apache2-foreground"]
