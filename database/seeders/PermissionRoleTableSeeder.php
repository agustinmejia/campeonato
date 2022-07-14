<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->firstOrFail();
        $permissions = Permission::all();
        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );

        // Rol de administrador
        $role = Role::where('name', 'administrador')->firstOrFail();
        $permissions = Permission::whereRaw("   `key` = 'browse_admin' or
                                                `table_name` = 'users' or
                                                `table_name` = 'clubs' or
                                                `table_name` = 'divisions' or
                                                `table_name` = 'categories' or
                                                `table_name` = 'teams' or
                                                `table_name` = 'players' or
                                                `table_name` = 'delegates' or
                                                `table_name` = 'championships' or
                                                `table_name` = 'reports' or
                                                `table_name` = 'settings'")->get();
        $role->permissions()->sync($permissions->pluck('id')->all());
        
        // Rol de delegado de club
        $role = Role::where('name', 'delegado_club')->firstOrFail();
        $permissions = Permission::whereRaw("   `key` = 'browse_admin' or
                                                `key` = 'browse_players' or
                                                `key` = 'read_players' or
                                                `table_name` = 'reports'")->get();
        $role->permissions()->sync($permissions->pluck('id')->all());
    }
}
