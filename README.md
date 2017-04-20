# Paidea Web System con Symfony V2

Se Implemta el siguiente Framework con sus respectivos Bundles:

#Symfony V2
  -FosUserBundle
  -FosRestBundle
  -FosOauthBundle

Para arrancar el projecto ejecutar los siguientes comandos en la raiz del proyecto desde la terminal:

Para instalar los bundles y elementos necesarios ejecutar el siguiente comando:

composer install

una vez instalados los bundles necesarios se necesita configurar algunas cosas:

#Actualizar la base de datos con el esquema actual:
php app/console doctrine:schema:create

#Iniciar los Data fixtures para llenar tablas prederterminadas:
php app/console doctrine:fixtures:load

#Crear el primer usuario
php app/console fos:user:create

#Instalar Assets necesarios
php app/console assets:install  

#Limpiar el cache
php app/console cache:clear 
