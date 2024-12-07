
## Fonctionalités principales
Ce projet est une application vitrine développée avec Symfony 6 et API Platform. Il a pour objectif de présenter et gérer un catalogue de produits en mettant en œuvre des fonctionnalités essentielles telles que :

Liste et pagination des produits : Les utilisateurs peuvent parcourir les produits organisés en pages pour une navigation fluide.
Exposition des produits via API Platform : Une API RESTful complète est configurée, permettant l'accès aux produits avec des actions comme ajout, modification, suppression, et consultation.


## Technologies utilisées
- **Framework** : Symfony 7
- **Sécurité authentification** : composant symfony Security
- **Base de données** : Doctrine ORM
- **Traduction** : Composant Symfony Translation
- **Langage** : PHP 8.2+
- 
- **API Platform** :  
  - Implémentation d'une API RESTful.  
  - Utilisation de filtres pour une recherche avancée.
  - Utlisation de système de group
  - Authentification JWT
  - 
- **Système de traduction**:  
  - Application multilingue avec prise en charge de plusieurs langues.  
  - Mise en œuvre de l'internationalisation (i18n).

## Dépendances utilisées    
- composer require api
- composer require symfony/security-bundle lexik/jwt-authentication-bundle
- composer require symfony/translation
- composer require knplabs/knp-paginator-bundle

