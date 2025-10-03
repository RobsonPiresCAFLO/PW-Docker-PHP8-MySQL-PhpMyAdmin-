FROM php:8.2-apache
# FROM php:7.4-apache

# Instala extensões necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia config customizada e garante que ela seja lida por último
COPY custom.ini /usr/local/etc/php/conf.d/zzz-custom.ini

# Copia configuração customizada do Apache
COPY apache-conf/000-default.conf /etc/apache2/sites-available/000-default.conf
