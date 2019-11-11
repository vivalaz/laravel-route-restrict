<?php

namespace Vivalaz\LaravelRouteRestrict\Models;

use Illuminate\Database\Eloquent\Model;
use Vivalaz\LaravelRouteRestrict\app\Exceptions\RouteAlreadyExistsException;
use Vivalaz\LaravelRouteRestrict\app\Exceptions\RouteDoesNotExistsException;
use Vivalaz\LaravelRouteRestrict\app\Helpers\Helper;

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
            throw RouteAlreadyExistsException::create($attributes['route']);
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
            throw RouteDoesNotExistsException::byId($id);
        }

        return $route;
    }

    /**
     * Find route by route path
     * @param string $routeName
     * @return Route
     */
    public static function findByRoute(string $routeName = ''): Route
    {
        $route = static::whereRoute($routeName)->first();

        if (!$route) {
            throw RouteDoesNotExistsException::byRoute($routeName);
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

    /**
     * Route has minimum one role that intersects with user roles
     * @param array $roles
     * @return bool
     */
    public function hasRoles(array $roles = [])
    {
        $routeRoles = Helper::getArrayOfIds($this->roles());

        $intersected = array_intersect($routeRoles, $roles);

        return count($intersected) > 0 ? true : false;
    }

    /**
     * Route has minimum one permission that intersects with user permissions
     * @param array $permissions
     * @return bool
     */
    public function hasPermissions(array $permissions = [])
    {
        $routePermissions = Helper::getArrayOfIds($this->permissions());

        $intersected = array_intersect($routePermissions, $permissions);

        return count($intersected) > 0 ? true : false;
    }
}