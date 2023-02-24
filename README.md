# GPMS-Gprocess

## Structure Project

```
+--app
|   +-- Console
|   +-- Criteria
|   +-- Exceptions
|   +-- Helpers
|   +-- Http
|   +-- Models
|   +-- Presenters
|   +-- Providers
|   +-- Repositories
|   |   +-- Eloquents
|   |   |   +-- BaseRepository.php
|   |   +-- EloquentRepositoryEloquentInterface.php
|   +-- Services
|   +-- Traits
|   +-- Transformers
|   +-- Validators
+-- bootstrap
+-- config
+-- database
|   +-- factories
|   +-- migrations
|   +-- seeders
+-- public
+-- resources
+-- routes
+-- storage
+-- tests
+-- .env
+-- artisan
+-- composer.json
+-- composer.lock
+-- package.json
+-- server.php
+-- webpack.mix.js
```

## Required

PHP: 8.1 or higher

Composer
## Setup

```
clone source from git repository
cd scc
cp .env.example .env
composer install
php artisan sail:install
```

choose 0 to set update DB with mysql or choose another services

After setup DB, run the following command to up container
```
make up
```

**Option**

`make shell` : to exec to main container which volume source code to

`make down` : to stop container

`make check` : to check code convention with phcs and phpmd

## Usage 

**Create new model**

Run the following command to create a new model with Request, Controller, Repository

Presenter, Transformer, Validator and Controller is optional which you can create with model as the same time


Migration file is auto generate too


```php artisan make:entity Model```

Refer : https://github.com/andersao/l5-repository

**Use Trait**

Using Trait GuzzleRequest in the first of class which you want to use to call api


Run App : http://localhost
PhpMyadmin : http://localhost:8080


## Git commit without check code

git commit -m "msg" --no-verify
