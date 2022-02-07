## Application parent prof

### processus d'installation
#### Etape 1:
- Clonez ou téléchargez le projet
- Ouvrir un terminal, ce deplacer vers dans le repertoire du projet
- Executez les commandes ``composer require symfony/runtime``  et ``npm install`` pour installer les dependances necessaires au projet
- Executer la commande ``php bin/console doctrine:database:create`` afin de créer la base de données

#### Etape 2:
- Mettez à jours le schema de la base de données avec la commande ``php bin/console doctrine:database:migrate``

#### Etape 3:
- Executez le projet avec les commandes: ``symfony server:start`` ou ``php -S localhost:8000 -t public`` 
- Synchronisez le front end avec la commande :``npm run dev server``

#### Outils
Pas necessaire pour executer le projet, mais utilse pour tester le dévéloppement de l'API et autres:
- Postman ``https://dl.pstmn.io/download/latest/win64``
