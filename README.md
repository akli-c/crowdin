On git clone

Ensuite on fait un "composer install"

On modifie le .env afin d'y entrer les bons paramètres de notre DB 

On fait un "php bin/console doctrine:schema:update -f"

Et enfin "symfony serve"