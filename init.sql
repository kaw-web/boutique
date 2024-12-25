-- Créer la base de données 'gallerie' si elle n'existe pas déjà
CREATE DATABASE IF NOT EXISTS gallerie;

-- Créer l'utilisateur 'symfony' avec le mot de passe 'symfony' si l'utilisateur n'existe pas déjà
CREATE USER IF NOT EXISTS 'symfony'@'%' IDENTIFIED BY 'symfony';

-- Accorder tous les privilèges sur la base de données 'gallerie' à l'utilisateur 'symfony'
GRANT ALL PRIVILEGES ON gallerie.* TO 'symfony'@'%';

-- Recharger les privilèges pour que les changements prennent effet
FLUSH PRIVILEGES;
