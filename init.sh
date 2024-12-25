#!/bin/bash

# Attendre que le serveur MySQL soit prêt
/usr/local/bin/wait-for-it.sh mysql:3306 --timeout=30 --strict -- echo "MySQL est prêt"

#php bin/console doctrine:schema:update --force
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction

# Démarrer Apache en mode premier plan
exec apache2-foreground