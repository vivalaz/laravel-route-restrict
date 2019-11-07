<?php

namespace Vivalaz\LaravelRouteRestrict\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{

    protected $fillable = [
        'route',
        'name',
        'description'
    ];

    public function roles() {
        return $this->hasMany(Role::class);
    }

    public function permissions() {
        return $this->hasMany(Permission::class);
    }

}