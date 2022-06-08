<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $role = Role::firstOrNew(['name' => 'admin']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.admin'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'user']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.user'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'administrador']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Administrador',
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'delegado_mesa']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Delegado de mesa',
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'delegado_club']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Delegado de club',
            ])->save();
        }
    }
}
