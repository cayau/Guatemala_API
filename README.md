## Guatemala API

Despues de clonar el repositorio

Ejecutar comando: composer update

Crear esquema de Base de Datos (nombre recomendado: guatemala-apidb)

Configurar archivo .env (usando .env.example) con la informacion de la base de datos

Ejecutar comando: php artisan migrate

Ejecutar comando: php artisan passport:install

Ejecutar comando: php artisan key:generate

Ejecutar comando: php artisan db:seed