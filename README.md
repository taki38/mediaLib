# mediaLib

Cette mission est réalisé pour MEDIA LIB dans le cadre d'un test de recrutement.

#Clonez le projet $ git clone https://github.com/taki38/mediaLib.git

#Allez dans le répertoire $ cd mediaLib

#Installer les dépendances (Vendor)

$ composer install

#Creation de la Base de données et des tables Editez la ligne 18 du .env pour mettre vos informations

$ php bin/console doctrine:database:create

$ php bin/console doctrine:make:migration

$ php bin/console doctrine:migrations:migrate

#Chargez les fixtures Fixtures $ php bin/console doctrine:fixtures:load

#Lancer l'application application $ symfony server:start

#Pour se connecter :

Utilisateur avec ROLE_ADMIN

email : takieddinesehailia@gmail.com / password : azerty

Utilisateur avec ROLE_USER

email : libmedia@gmail.com / password : azerty
