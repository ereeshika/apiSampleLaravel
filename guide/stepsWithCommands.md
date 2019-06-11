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
        // link to a row from parent table
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

## API Resources

### Resources

A transformation layer that sits between your Eloquent models and the JSON responses that are actually returned to your application's users. Laravel's resource classes allow you to expressively and easily transform your models and model collections into JSON.

To generate a resource class, you may use the make:resource Artisan command. By default, resources will be placed in the app/Http/Resources directory of your application. Resources extend the Illuminate\Http\Resources\Json\JsonResource class

```console
php artisan make:resource RelatedModelName
```

Here we can curate how our original data should be sent to the end user

```php

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'content' => $this->details,
            'price' => $this->price,
            'stock' => $this->availableCopies == 0 ? 'No Stocks available' : $this->availableCopies,
            'discount' => $this->discount == 0 ? 'No Discounts' : $this->discount,
            // connect data from other related models
            'rating' => $this->feedbacks->count() > 0 ? round($this->feedbacks->sum('rating') / $this->feedbacks->count()) : 'No Ratings Yet',
            'comments' => $this->feedbacks->count('commment') > 0 ? $this->feedbacks->count('commment') : 'Be the First one to Comment',
            // sending links to another json
            'href' => [
                'feedbacks' => route('feedbacks.index', $this->id)
            ]
        ];
    }
}

```

### Resource Collections

Sometimes you may need to generate resources that are responsible for transforming collections of models. Which allows your response to include links and other meta information that is relevant to an entire collection of a given resource.

To create a resource collection, you should use the --collection flag when creating the resource. Or, including the word Collection in the resource name will indicate to Laravel that it should create a collection resource. Collection resources extend the  Illuminate\Http\Resources\Json\ResourceCollection class:

```console
php artisan make:resource Users --collection
```

or

```console
php artisan make:resource UserCollection
```

## Laravel Passport Setup

APIs typically use tokens to authenticate users and do not maintain session state between requests. Laravel makes API authentication a breeze using Laravel Passport, which provides a full OAuth2 server implementation.

### installation

```console
composer require laravel/passport
```

then

```console
php artisan migrate
```

and finally

```console
php artisan passport:install
```

### Configuration

1. go to User.php (User model) and update
   > use HasApiTokens,Notifiable;

 Add below line to the top as well
   >use Laravel\Passport\HasApiTokens;

2. in AuthService provider boot method
   > Passport::routes();

Add below line to the top as well
   > use Laravel\Passport\Passport;

3. Last but not least inside config/auth.php

    ```php
        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
            'hash' => false,
        ],
    ```

### Get Access Token for POSTMAN

1. Create a **POST** request to
   > <http://127.0.0.1:8000/oauth/token>

2. Add below headers
   1. > Key :Accept Value:application/json
   2. > Key :Content-type Value:application/json

3. Add below body in raw format. Before doing that create user after enablin
   > php artisan make:auth
then

   ```json
   {
    "grant_type" : "password",
    "client_id" : "2",
    "client_secret" : "0ORPAw7EjJbjGAx82mGr3Pnvm9XirYsgHX7aUp1U",
    "username" : "user@test.com",
    "password" : "test1234"
    }
   ```

4. Make the request and copy the access token from the result
5. Then add a New Environment in POSTMAN and add variable **auth** with initial value 
   > Bearer AccessTokenValue
6. Finally you can use it in your request headers as follows
   >Key: Authorization Value:{{auth}}
