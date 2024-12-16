# Utiliser une image PHP avec Apache
FROM php:8.2-apache

# Installer les dépendances
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install intl pdo pdo_mysql zip opcache

# Activer mod_rewrite pour Apache
RUN a2enmod rewrite

# Copier les fichiers du projet Symfony dans le conteneur
COPY . /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

# Mettre à jour et installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts

# Vérification des permissions (ajouter pour éviter des problèmes de permissions)
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Ajouter la configuration Apache personnalisée
COPY symfony.conf /etc/apache2/sites-available/000-default.conf

# Exposer le port pour l'application Symfony
EXPOSE 8000

CMD ["apache2-foreground"]