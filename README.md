# Request Validation

## 📦 Instalação

#### Use o comando a baixo para instalar com **composer**
```bash
composer require grupo-cometa/request-validation
```
#### Registre o Command  **GrupoCometa\Validations\Commands\GeneratorValidation** em app\Console\Kernel.php
```php
<?php

namespace App\Console;
use GrupoCometa\Validations\Commands\GeneratorValidation;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  
    protected $commands = [
        GeneratorValidation::class
    ];

}

```

## 🔨 Usando
#### Por padrão são criadas duas  classes de validação em **app\Http\Middlerware\Validations**
```bash
php artisan validations:generator {model}
```
####  Exemple Generator
```bash
php artisan validations:generator App\\Models\\Users
```
#### Aplicação 
- app
  - Http
    - Middlerware
        - Validations
            - UserUpdateValidation.php
            - UserStoreValidation.php

## Usando Validation em sua rota
```php
<?php
use App\Http\Middleware\Validations\Robot\UserStoreValidation;
use App\Http\Middleware\Validations\Robot\UserUpdateValidation;

$router->post('/', [
    'uses' => 'UserController@store',
    'middleware' => [UserStoreValidation::class]
]);

$router->put('/', [
    'uses' => 'UserController@update',
    'middleware' => [UserUpdateValidation::class]
]);

```