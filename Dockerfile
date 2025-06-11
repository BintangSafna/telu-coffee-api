# Gunakan image PHP 8.1 dengan Apache
FROM php:8.1-apache

# Copy semua file project ke folder root Apache
COPY . /var/www/html/

# Aktifkan mod_rewrite Apache (jika pakai .htaccess di project-mu)
RUN a2enmod rewrite
