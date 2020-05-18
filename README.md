# Marketplace test laravel


## Why am create this application

The application is the way to test and improve my ability in API REST, trainning my programming skills, to practice the TDD think and another things about web development.

## Purpose of this application

The application is a api json that will serve like a simple backend of a SPA marketplace. It will send the products and save the users orders and another functions.

## To start this application

```
compose update
php artisan serve
```
### Be attention, you will need run the compose update command inside your project folder to load the dependencies of laravel.

## To test

``
php artisan test
`` 

## The database

Don't forget that you will need set a database configuration for it


## The Api routes 

the routes are mapped to this uris. 

```
POST /api/login

"Authentication Header" : "Bearer " + token

{
    "email": "user@user.com",
    "password": "123"
}
```

```
POST /api/register

{
    "name": "user",
    "email": "user@user.com",
    "password": "123"
}
```

```
GET /api/logout
```

```
GET /api/products
``` 

```
POST /api/product

{
    "description": "Product",
    "price" : 0.00,
    "category_id": 1
}
```

```
PUT /api/product/{id}

{
    "description": "Change product",
    "price" : 1.00,
    "category_id": 1
}
```

```
DELETE /api/product/{id}
```

```
GET /api/categories
```

```
POST /api/category/{id}

{
    "description": "Informatics"
}
```

```
PUT /api/category/{id}
{
    "description": "Change category"
}
```

```
DELETE /api/category/{id}
```











The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
