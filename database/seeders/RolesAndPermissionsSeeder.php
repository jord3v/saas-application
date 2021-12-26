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
            ['name' => 'role-list', 'guard_name' => 'web'],
            ['name' => 'role-create', 'guard_name' => 'web'],
            ['name' => 'role-edit', 'guard_name' => 'web'],
            ['name' => 'role-delete', 'guard_name' => 'web'],
        ];
        
        foreach ($permissions as $permission) {
            $this->permission::create($permission);
        }

        // this can be done as separate statements
        $role = $this->role::create(['name' => 'Usuário']);
        //$role->givePermissionTo('property-edit');

        // or may be done by chaining
        $role = $this->role::create(['name' => 'Administrador']);
        $role->givePermissionTo($this->permission::all());
    }
}