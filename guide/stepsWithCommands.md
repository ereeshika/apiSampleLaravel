# Simple Guide for ReSTful API with Laravel

## Initating project

Basic setup to get the project up and running

### Basic setup to get the project up and running

#### create project

```console
php artisan composer create-project --prefer-dist laravel/laravel blog
```

#### install composer dependencies

```console
composer install
```

#### install npm dependencies

```console
npm install
```

#### generate app key

```console
php artisan key:generate
```

#### run database migrations

```console
php artisan migrate
```

#### run app in the local environment

```console
php artisan serve
```

## Setting up api

### some text

#### Create a model with a migration, factory, and resource controller for the model

```console
php artisan make:model ModelName -a
```

if you place your api related controllers in a separate file, you need to change below details of each controller file,

-   Update this line

> namespace App\Http\Controllers\FolderName;

-   Add this line

> use App\Http\Controllers\Controller;

#### setup routes

Using the beow notation resource will only declare api routes (index,store,show,update,destroy excluding create and edit).
On api.php

> Route::apiResource('/url', 'APIFolderName\ControllerName')

Declare routes with prefix from another

> Route::group(['prefix'=>'articles'], function(){
> Route::apiResource('/{article}/feedbacks', 'API\FeedBackController');
> });

#### cascade delete if the parent table row is deleted

in the migration file

> \$table->integer('article_id')->unsigned()->index();

> \$table->foreign('article_id')->references('parentTablePK')->on('parentTable')->onDelete('cascade');

### create factory and seeder

```php
use App\Model\Article;
use App\Model\Feedback;
use Faker\Generator as Faker;

$factory->define(Feedback::class, function (Faker $faker) {
    return [
        // link to row from parent table
        'article_id' => function () {
            return Article::all()->random();
        },
        'reader' => $faker->name,
        'commment' => $faker->paragraph,
        'rating' => $faker->numberBetween(0, 5)
    ];
});
```

run seeder

```console
php artisan db:seed
```
