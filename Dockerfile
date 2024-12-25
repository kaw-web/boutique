# Utiliser une image PHP avec Apache
FROM php:8.2-apache

# Installer les dépendances
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    dos2unix \
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

# Vérification des permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html


# Télécharger le script wait-for-it
ADD https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh


# Ajouter la configuration Apache personnalisée
COPY symfony.conf /etc/apache2/sites-available/000-default.conf


# Copier le script d'initialisation
COPY init.sh /usr/local/bin/init.sh
RUN chmod +x /usr/local/bin/init.sh
#RUN dos2unix /usr/local/bin/init.sh

# Définir l'ENTRYPOINT pour exécuter le script d'initialisation
#ENTRYPOINT ["/usr/local/bin/init.sh"]


# Exposer le port pour l'application Symfony
EXPOSE 8000

# Définir l'ENTRYPOINT pour exécuter le script d'initialisation
ENTRYPOINT ["/usr/local/bin/init.sh"]

# Démarrer Apache en mode premier plan
CMD ["apache2-foreground"]
