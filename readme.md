**Associate project routes with user permissions and roles**

This package allows you to extend default **[spatie/laravel-permission](https://github.com/spatie/laravel-permission "spatie/laravel-permission")** behavoir and manage project routes via roles and permissions which are assigned to users.

#Installation

//todo: make composer installation

You can manually add package to the project service provider in your ```config/app.php``` file:

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
