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

<br /><br />
# Example

```php

$query = "
        { users{id,name,email} }
        ";

$r = GraphQL::query( $query );

// check if the response has errors
if( $r->hasErrors() )
{
    // return a string of the first error messasge
    dd($r->getErrorMessage());

    // return a laravel collection with the errors
    dd($r->errors());
}

// will return laravel collection
dd( $r->get('users') );
dd( $r->users );

```

## Query params

```php

/**
* @param  string  $query : { users{id, name, email} }
* @param  array  $params : extra parameters in the POST
* @param  integer $cache : in minutes
* @return Response
*/
$r = GraphQL::query( $query, $params=[], $cache=false );

```