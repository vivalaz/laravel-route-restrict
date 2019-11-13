<?php

namespace Vivalaz\LaravelRouteRestrict;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class LaravelRouteRestrictServiceProvider extends ServiceProvider
{

    /**
     * Migration file name, stored in database/migrations.
     * @var string
     */
    protected $migrationFileName = 'create_route_permission_tables';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/laravel-route-restrict.php',
            'laravel-route-restrict'
        );
    }

    /**
     * Bootstrap services.
     *
     * @param Filesystem $fs
     * @return void
     */
    public function boot(Filesystem $fs)
    {
        $this->publishes([
            __DIR__ . '/config/laravel-route-restrict.php' => config_path('laravel-route-restrict.php')
        ], 'config');

        $this->publishes([
            __DIR__ . "/database/migrations/{$this->migrationFileName}.php.stub" => $this->getMigrationName($fs)
        ], 'migrations');
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @param Filesystem $fs
     * @return string
     */
    protected function getMigrationName(Filesystem $fs)
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($fs) {
                return $fs->glob($path . "*_{$this->migrationFileName}.php");
            })->push($this->app->databasePath() . "/migrations/{$timestamp}_{$this->migrationFileName}.php")
            ->first();
    }
}
