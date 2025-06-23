FROM php:8.1-apache

# Copy all files into the web root
COPY . /var/www/html/

# Enable Apache rewrite module (optional)
RUN a2enmod rewrite

EXPOSE 80
