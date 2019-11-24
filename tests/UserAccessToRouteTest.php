<?php


namespace Vivalaz\LaravelRouteRestrict\Test;


use Vivalaz\LaravelRouteRestrict\Models\Route;

class UserAccessToRouteTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        app(Route::class)->create([
            'route' => 'user/route',
            'method' => 'GET'
        ]);

        app(Route::class)->create([
            'route' => 'admin/route',
            'method' => 'POST'
        ]);

    }

    /**
     * @test
     */
    public function userHasAccessToRoute()
    {

    }

    /**
     * @test
     */
    public function userDoesNotHaveAccessToRoute()
    {

    }

}