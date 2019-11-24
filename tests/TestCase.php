<?php


namespace Vivalaz\LaravelRouteRestrict\Test;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Vivalaz\LaravelRouteRestrict\LaravelRouteRestrictServiceProvider;


abstract class TestCase extends Orchestra
{

    use RefreshDatabase;

    protected $testUser;
    protected $testAdmin;

    protected $roleAdmin;
    protected $roleUser;

    protected $permissionUser;
    protected $permissionAdmin;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'route_restrict_test');
        $app['config']->set('database.connections.route_restrict_test', [
            'driver' => 'sqlite',
            'database' => 'route_restrict_test',
            'prefix' => ''
        ]);

        $app['config']->set('auth.providers.users.model', User::class);

        $app['config']->set('permission.models.permission', Permission::class);
        $app['config']->set('permission.models.role', Role::class);
        $app['config']->set('permission.table_names.roles', 'roles');
        $app['config']->set('permission.table_names.permissions', 'permissions');
        $app['config']->set('permission.table_names.model_has_permissions', 'model_has_permissions');
        $app['config']->set('permission.table_names.model_has_permissions', 'model_has_permissions');
        $app['config']->set('permission.table_names.model_has_roles', 'model_has_roles');
        $app['config']->set('permission.table_names.role_has_permissions', 'role_has_permissions');
        $app['config']->set('permission.column_names.model_morph_key', 'model_id');
    }

    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('email');
        });

        include_once __DIR__ . '/../vendor/spatie/laravel-permission/database/migrations/create_permission_tables.php.stub';
        (new \CreatePermissionTables())->up();

        include_once __DIR__.'/../src/database/migrations/create_route_permission_tables.php.stub';
        (new \CreateRoutePermissionTables())->up();

        $this->roleUser = $app[Role::class]->create(['name' => 'UserRole']);
        $this->roleAdmin = $app[Role::class]->create(['name' => 'AdminRole']);

        $this->permissionUser = $app[Permission::class]->create(['name' => 'UserPermission']);
        $this->permissionAdmin = $app[Permission::class]->create(['name' => 'AdminPermission']);

        $this->testUser = User::create(['email' => 'user@user.com']);
        $this->testUser->assignRole('UserRole');

        $this->testAdmin = User::create(['email' => 'admin@user.com']);
        $this->testAdmin->assignRole('AdminRole');
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