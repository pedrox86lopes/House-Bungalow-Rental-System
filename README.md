# House-Bungalow-Rental-System
A House and Bungalows Rental System developed in Laravel

### Steps
1 - composer create-project --prefer-dist laravel/laravel Reservas

2 - composer require laravel/breeze --dev

3 - php artisan breeze:install  

4 - composer require laravel/ui

5 - php artisan ui bootstrap --auth      

6 - npm install

### Create required Models and Controllers
1 - php artisan make:model Models/TipoBem

2 - php artisan make:model Models/Marca

3 - php artisan make:model Models/BemLocavel

4 - php artisan make:model Models/Localizacao

5 - php artisan make:model Models/Caracteristica

6 - php artisan make:model Models/BemCaracteristica

7 - php artisan make:controller CatalogoController 


### The required .sql is located in 
/database/scripts/<b>locacao_casas_ferias.sql</b>
