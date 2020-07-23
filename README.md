# Guatemala API

## Instalacion

Porfavor revisar la guia de instalacion oficial de laravel para requerimientos de servidor, antes de iniciar. [Documentacion Oficial](https://laravel.com/docs/7.x/installation#installation)

Despues de clonar el repositorio
    
    git clone git@github.com:cayau/Guatemala_API.git

Para instalar las dependencia ejecutar comando
    
    composer update

Crear esquema de Base de Datos
    
    (nombre recomendado: guatemala-apidb)

Configurar archivo .env (usando .env.example) con la informacion de la base de datos
        
    cp .env.example .env

Coirrer migraciones de base de datos ejecutar comando
    
    php artisan migrate

Instalar passport para autenticacion ejecutar comando
    
    php artisan passport:install

Generar nueva llave de aplicacion ejecutar comando
    
    php artisan key:generate

Para crear data dummy en la base de datos ejecutar comando
    
    php artisan db:seed

Para hacer login utilizar las credenciales:
    
    correo: ayau15@gmail.com
    contrasena: guatemala1234
