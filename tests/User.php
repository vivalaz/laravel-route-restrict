<?php


namespace Vivalaz\LaravelRouteRestrict\Test;


use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Auth\Authenticatable;
use Vivalaz\LaravelRouteRestrict\Traits\HasRouteAccess;

class User extends Model implements AuthorizableContract, AuthenticatableContract
{

    use HasRoles, Authorizable, Authenticatable;
    use HasRouteAccess;

    protected $table = 'users';

    protected $fillable = [
        'email'
    ];

    public $timestamps = false;
}