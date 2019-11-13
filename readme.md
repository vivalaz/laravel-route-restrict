[![Latest Stable Version](https://poser.pugx.org/vivalaz/laravel-route-restrict/v/stable)](https://packagist.org/packages/vivalaz/laravel-route-restrict)
[![Latest Unstable Version](https://poser.pugx.org/vivalaz/laravel-route-restrict/v/unstable)](https://packagist.org/packages/vivalaz/laravel-route-restrict)
[![Total Downloads](https://poser.pugx.org/vivalaz/laravel-route-restrict/downloads)](https://packagist.org/packages/vivalaz/laravel-route-restrict)
[![License](https://poser.pugx.org/vivalaz/laravel-route-restrict/license)](https://packagist.org/packages/vivalaz/laravel-route-restrict)
[![Daily Downloads](https://poser.pugx.org/vivalaz/laravel-route-restrict/d/daily)](https://packagist.org/packages/vivalaz/laravel-route-restrict)
[![Monthly Downloads](https://poser.pugx.org/vivalaz/laravel-route-restrict/d/monthly)](https://packagist.org/packages/vivalaz/laravel-route-restrict)

**Associate project routes with user permissions and roles**

This package allows you to extend default **[spatie/laravel-permission](https://github.com/spatie/laravel-permission "spatie/laravel-permission")** behavoir and manage project routes via roles and permissions which are assigned to users.

# Installation

//todo: make composer installation

**Or you can manually add package to your project:**

Firstly, you need to add autoload to project ```composer.json```. Let's go ahead and autoload our package via the PSR-4 autoload block:
```
"autoload": {
    "psr-4": {
        "Vivalaz\\LaravelRouteRestrict\\": "packages/Vivalaz/laravel-route-restrict/src"
    }
},
```
Then we need composer to run the autoloader and autoload our package. To do this we run the following command: ```composer dump-autoload```.

Then add package to the project service provider in your ```config/app.php``` file:

```
	'providers' => [
		// ...
		
		Vivalaz\LaravelRouteRestrict\LaravelRouteRestrictServiceProvider::class
		
		//..
	]
```

Next you should publish the migration with:
```
php artisan vendor:publish --provider="Vivalaz\LaravelRouteRestrict\LaravelRouteRestrictServiceProvider" --tag="migrations"
```

After the migration has been published you can create the role- and permission-tables for routes by running the migrations:
```php artisan migrate```

You can publish the config file with:
```
php artisan vendor:publish --provider="Vivalaz\LaravelRouteRestrict\LaravelRouteRestrictServiceProvider" --tag="config"
```

When published, the ```config/laravel-route-restrict.php``` config file initially contains:
```
return [

    'models' => [
        'route' => Vivalaz\LaravelRouteRestrict\Models\Route::class
    ],

    'table_names' => [
        'routes' => 'routes',
        'route_for_roles' => 'route_for_roles',
        'route_for_permissions' => 'route_for_permissions'
    ]
    
];
```

# Basic usage

Firstly, add the ```Vivalaz\LaravelRouteRestrict\Traits\HasRouteAccess``` trait to your ```User``` model:

```
class User extends Authenticatable
{
    // ...
	
    use HasRouteAccess;
	
	//...
}
```

This package allows for routes to be associated with user permissions and roles. [(More about Roles and Permissions)](https://github.com/spatie/laravel-permission "(More about Roles and Permissions)").

For add roles or permissions that can be accessed by user you need to create new ```Route``` in database. Then you can sync roles or permissions:
```
// sync roles to route
Route::create(['route' => 'api/route'])->syncRoles([1]);
// sync permissions to route
Route::create(['route' => 'api/permissions_route'])->syncPermissions([1,2,3]);
```

Next you need to add middlewares to routes. Firstly, register middlewares in ```Kernel.php``` file in ```$routeMiddleware```.
```
protected $routeMiddleware = [
	// **
	'route_has_roles' => RouteHasRolesMiddleware::class,
	'route_has_permissions' => RouteHasPermissionsMiddleware::class,
	'route_has_roles_or_permissions' => RouteHasRolesOrPermissionsMiddleware::class
	//**
    ];
```

1. ``` RouteHasRolesMiddleware::class``` - check if user has roles that route has. If user doesnt have any role, which are allowed for route it throws 403 Forbidden.
2. ``` RouteHasPermissionsMiddleware::class``` - check if user has permissions that route has. If user doesnt have any permission, which are allowed for route it throws 403 Forbidden.
3. ```RouteHasRolesOrPermissionsMiddleware::class``` - - check if user has roles or permissions that route has. If user doesnt have any role or permission, which are allowed for route it throws 403 Forbidden.

Then you can add registered middlewares to route protection. In ```web.php``` or ```api.php``` you can protect separate route:
```
Route::get('/home', 'HomeController@index')->middleware('route_has_roles_or_permissions');
```
or you can protect group of routes:
```
Route::group(['middleware' => 'route_has_roles_or_permissions'], function() {
    Route::get('/home', 'HomeController@index');
});
```

**WARNING: If route not spicified in database, then it can be accessed by any user with any role or permission.**
