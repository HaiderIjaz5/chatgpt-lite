<<<<<<< HEAD
FROM php:8.1-apache

# Copy all files into the web root
COPY . /var/www/html/

# Enable Apache rewrite module (optional)
RUN a2enmod rewrite

EXPOSE 80
=======
FROM php:8.1-apache

# Copy all files into the web root
COPY . /var/www/html/

# Enable Apache rewrite module (optional)
RUN a2enmod rewrite

EXPOSE 80
>>>>>>> 59775e60c9a02355eecb2d1f6ccdd7ff525f1d2f
