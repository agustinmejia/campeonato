<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('data_types')->delete();
        
        \DB::table('data_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'users',
                'slug' => 'users',
                'display_name_singular' => 'User',
                'display_name_plural' => 'Users',
                'icon' => 'voyager-person',
                'model_name' => 'TCG\\Voyager\\Models\\User',
                'policy_name' => 'TCG\\Voyager\\Policies\\UserPolicy',
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController',
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"desc","default_search_key":null,"scope":null}',
                'created_at' => '2021-06-02 17:55:30',
                'updated_at' => '2022-06-08 19:31:03',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'menus',
                'slug' => 'menus',
                'display_name_singular' => 'Menu',
                'display_name_plural' => 'Menus',
                'icon' => 'voyager-list',
                'model_name' => 'TCG\\Voyager\\Models\\Menu',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2021-06-02 17:55:30',
                'updated_at' => '2021-06-02 17:55:30',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'roles',
                'slug' => 'roles',
                'display_name_singular' => 'Role',
                'display_name_plural' => 'Roles',
                'icon' => 'voyager-lock',
                'model_name' => 'TCG\\Voyager\\Models\\Role',
                'policy_name' => NULL,
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2021-06-02 17:55:31',
                'updated_at' => '2021-06-02 17:55:31',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'clubs',
                'slug' => 'clubs',
                'display_name_singular' => 'Club',
                'display_name_plural' => 'Clubes',
                'icon' => 'voyager-shop',
                'model_name' => 'App\\Models\\Club',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":"name","order_display_column":"name","order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2022-03-28 17:40:20',
                'updated_at' => '2022-07-13 18:07:19',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'divisions',
                'slug' => 'divisions',
                'display_name_singular' => 'Divisi??n',
                'display_name_plural' => 'Divisiones',
                'icon' => 'voyager-list',
                'model_name' => 'App\\Models\\Division',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2022-03-28 17:49:49',
                'updated_at' => '2022-03-29 18:36:23',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'categories',
                'slug' => 'categories',
                'display_name_singular' => 'Categor??a',
                'display_name_plural' => 'Categor??as',
                'icon' => 'voyager-list',
                'model_name' => 'App\\Models\\Category',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2022-03-28 17:52:15',
                'updated_at' => '2022-03-29 21:20:59',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'teams',
                'slug' => 'teams',
                'display_name_singular' => 'Equipo',
                'display_name_plural' => 'Equipos',
                'icon' => 'voyager-people',
                'model_name' => 'App\\Models\\Team',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2022-03-28 18:02:35',
                'updated_at' => '2022-03-28 18:09:14',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'players',
                'slug' => 'players',
                'display_name_singular' => 'Jugador',
                'display_name_plural' => 'Jugadores',
                'icon' => 'voyager-person',
                'model_name' => 'App\\Models\\Player',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2022-03-28 18:21:21',
                'updated_at' => '2022-04-27 00:06:39',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'delegates',
                'slug' => 'delegates',
                'display_name_singular' => 'Delegado',
                'display_name_plural' => 'Delegados',
                'icon' => 'voyager-people',
                'model_name' => 'App\\Models\\Delegate',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2022-04-27 00:07:49',
                'updated_at' => '2022-04-27 01:01:21',
            ),
            9 => 
            array (
                'id' => 11,
                'name' => 'permissions',
                'slug' => 'permissions',
                'display_name_singular' => 'Permiso',
                'display_name_plural' => 'Permisos',
                'icon' => 'voyager-window-list',
                'model_name' => 'App\\Models\\Permission',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":"table_name","order_display_column":"table_name","order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2022-06-10 00:28:08',
                'updated_at' => '2022-06-10 00:29:57',
            ),
            10 => 
            array (
                'id' => 13,
                'name' => 'championships',
                'slug' => 'championships',
                'display_name_singular' => 'Campeonato',
                'display_name_plural' => 'Campeonatos',
                'icon' => 'voyager-trophy',
                'model_name' => 'App\\Models\\Championship',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null}',
                'created_at' => '2022-07-13 20:30:25',
                'updated_at' => '2022-07-13 20:30:25',
            ),
        ));
        
        
    }
}