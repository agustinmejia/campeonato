<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $keys = [
            'browse_admin',
            'browse_bread',
            'browse_database',
            'browse_media',
            'browse_compass',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => null,
            ]);
        }

        Permission::generateFor('menus');
        Permission::generateFor('permissions');
        Permission::generateFor('roles');
        Permission::generateFor('users');
        Permission::generateFor('settings');
        Permission::generateFor('clubs');
        Permission::generateFor('divisions');
        Permission::generateFor('categories');
        Permission::generateFor('teams');
        Permission::generateFor('players');
        Permission::generateFor('delegates');
        Permission::generateFor('championships');
        Permission::generateFor('championshipscategories');

        $keys = [
            'options_players',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => 'players',
            ]);
        }


        $keys = [
            'browse_reportsplayers',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => 'reports',
            ]);
        }
    }
}
