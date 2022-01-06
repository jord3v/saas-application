<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    private $role;
    private $permission;
    
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;    
        $this->permission = $permission;    
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            // roles
            ['name' => 'roles-list', 'type' => 'roles', 'guard_name' => 'web'],
            ['name' => 'roles-create', 'type' => 'roles', 'guard_name' => 'web'],
            ['name' => 'roles-edit', 'type' => 'roles', 'guard_name' => 'web'],
            ['name' => 'roles-delete', 'type' => 'roles', 'guard_name' => 'web'],

            // settings
            ['name' => 'settings', 'type' => 'settings', 'guard_name' => 'web'],

            // subscriptions
            ['name' => 'subscriptions-list', 'type' => 'subscriptions', 'guard_name' => 'web'],
            ['name' => 'subscriptions-create', 'type' => 'subscriptions', 'guard_name' => 'web'],
            ['name' => 'subscriptions-edit', 'type' => 'subscriptions', 'guard_name' => 'web'],

            //users
            // roles
            ['name' => 'users-list', 'type' => 'users', 'guard_name' => 'web'],
            ['name' => 'users-create', 'type' => 'users', 'guard_name' => 'web'],
            ['name' => 'users-edit', 'type' => 'users', 'guard_name' => 'web'],
            ['name' => 'users-delete', 'type' => 'users', 'guard_name' => 'web'],
        ];
        
        foreach ($permissions as $permission) {
            $this->permission::create($permission);
        }

        // or may be done by chaining
        $role = $this->role::create(['name' => 'Administrador']);
        $role->givePermissionTo($this->permission::all());
    }
}