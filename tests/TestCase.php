<?php


namespace Vivalaz\LaravelRouteRestrict\Test;

use Orchestra\Testbench\TestCase as Orchestra;
use Vivalaz\LaravelRouteRestrict\LaravelRouteRestrictServiceProvider;


abstract class TestCase extends Orchestra
{

    protected $testUser;
    protected $testAdmin;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

//        $this->testUser = User::first();
    }

    protected function setUpDatabase($app)
    {
        // todo: create roles, permissions, users
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelRouteRestrictServiceProvider::class
        ];
    }

}