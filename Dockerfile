FROM php:8.2-apache

# Skopiuj pliki do katalogu WWW
COPY . /var/www/html/

# Ustaw uprawnienia
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
