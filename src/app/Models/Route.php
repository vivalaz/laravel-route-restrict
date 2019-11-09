<?php

namespace Vivalaz\LaravelRouteRestrict\Models;

use Illuminate\Database\Eloquent\Model;
use Vivalaz\LaravelRouteRestrict\app\Exceptions\RouteAlreadyExists;
use Vivalaz\LaravelRouteRestrict\app\Exceptions\RouteDoesNotExists;

class Route extends Model
{

    protected $fillable = [
        'route',
        'name'
    ];

    /**
     * A route may be given various roles.
     */
    public function roles()
    {
        return $this->belongsToMany(
            config('permission.models.role'),
            config('laravel-route-restrict.table_names.route_for_roles'),
            'route_id',
            'role_id'
        );
    }

    /**
     * A route may be given various permissions.
     */
    public function permissions()
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('laravel-route-restrict.table_names.route_for_permissions'),
            'route_id',
            'permission_id'
        );
    }

    /**
     * Override Eloquent's default create function
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    public static function create(array $attributes = [])
    {
        if (static::whereRoute($attributes['route'])->first()) {
            throw RouteAlreadyExists::create($attributes['route']);
        }

        return static::query()->create($attributes);
    }

    /**
     * Find route by his id
     * @param int $id
     * @return Route
     */
    public static function findById(int $id): Route
    {
        $route = static::find($id);

        if (!$route) {
            throw RouteDoesNotExists::byId($id);
        }

        return $route;
    }

    /**
     * Find route by route path
     * @param string $route
     * @return Route
     */
    public static function findByRoute(string $route = ''): Route
    {
        $route = static::whereRoute($route)->first();

        if (!$route) {
            throw RouteDoesNotExists::byRoute($route);
        }

        return $route;
    }

    /**
     * Sync roles for routes
     * @param array $roleIds
     * @return Route
     */
    public function syncRoles(array $roleIds = []): Route
    {
        $this->roles()->sync($roleIds);

        return $this;
    }

    /**
     * Sync permissions for routes
     * @param array $permissionIds
     * @return Route
     */
    public function syncPermissions(array $permissionIds = []): Route
    {
        $this->permissions()->sync($permissionIds);

        return $this;
    }

}