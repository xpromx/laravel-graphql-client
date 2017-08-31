# Instalation


### Composer.json
add to your composer.json the package and the repository.

```
   "require": {
        "travelience/laravel-graphql-client": "dev-master"
   },
   "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/xpromx/laravel-graphql-client.git",
            "no-api": true
            
        }
    ]
```



### Service Provider

```
Travelience\GraphQL\GraphQLServiceProvider::class,
```



### Config Files
In order to edit the default configuration for this package you may execute:

```
php artisan vendor:publish
```

