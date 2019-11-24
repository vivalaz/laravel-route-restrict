<?php


namespace Vivalaz\LaravelRouteRestrict\Test;


use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class User extends Model
{

    use HasRoles;

    protected $table = 'users';

    protected $fillable = [
        'email'
    ];

    public $timestamps = false;

}