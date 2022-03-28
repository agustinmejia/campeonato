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
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2021-06-02 17:55:30',
                'updated_at' => '2021-06-02 17:55:30',
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
                'updated_at' => '2022-03-28 17:53:19',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'divisions',
                'slug' => 'divisions',
                'display_name_singular' => 'División',
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
                'updated_at' => '2022-03-28 17:53:37',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'categories',
                'slug' => 'categories',
                'display_name_singular' => 'Categoría',
                'display_name_plural' => 'Categorías',
                'icon' => 'voyager-list',
                'model_name' => 'App\\Models\\Category',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2022-03-28 17:52:15',
                'updated_at' => '2022-03-28 18:10:22',
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
                'updated_at' => '2022-03-28 18:25:03',
            ),
        ));
        
        
    }
}