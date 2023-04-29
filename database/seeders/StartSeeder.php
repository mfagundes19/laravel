<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('module')->insert([    ///1
            'name' => 'Módulos',
            'module' => 'module',
            'active' => true
        ]);
        DB::table('module')->insert([    ///2
            'name' => 'Menu',
            'module' => 'menu',
            'active' => true
        ]);
        DB::table('module')->insert([    //3
            'name' => 'Usuários',
            'module' => 'user',
            'active' => true
        ]);
        DB::table('module')->insert([    //4
            'name' => 'Perfil',
            'module' => 'role',
            'active' => true
        ]);         
        DB::table('menu')->insert([       //1
            'module_id' => null,
            'name' => 'Configuração',
            'link' => '',
            'nivel' => 1,
            'active' => true
        ]);     
        DB::table('menu')->insert([       //2
            'module_id' => null,
            'name' => 'Sistema',
            'link' => '',
            'nivel' => 1,
            'active' => true
        ]);    
        DB::table('menu')->insert([       //3
            'module_id' => null,
            'name' => 'Cadastros',
            'link' => '',
            'nivel' => 1,
            'active' => true
        ]);      
        DB::table('menu')->insert([       //4
            'module_id' => null,
            'name' => 'Operacional',
            'link' => '',
            'nivel' => 1,
            'active' => true
        ]);  
        DB::table('menu')->insert([
            'module_id' => 1,
            'name' => 'Módulos',
            'link' => 'module',
            'nivel' => 2,
            'nivel_1_menu_id' => 1,
            'active' => true
        ]);
        DB::table('menu')->insert([
            'module_id' => 2,
            'name' => 'Menu',
            'link' => 'menu',
            'nivel' => 2,
            'nivel_1_menu_id' => 1,
            'active' => true
        ]);
        DB::table('menu')->insert([
            'module_id' => 3,
            'name' => 'Usuários',
            'link' => 'user',
            'nivel' => 2,
            'nivel_1_menu_id' => 2
        ]);
        DB::table('menu')->insert([
            'module_id' => 4,
            'name' => 'Perfil',
            'link' => 'role',
            'nivel' => 2,
            'nivel_1_menu_id' => 2,
            'active' => true
        ]);
        DB::table('role')->insert([
            'name' => 'Administrator',
            'active' => true
        ]);
        for($i=1; $i <= 4; $i++) {
            DB::table('role_permission')->insert([
                'role_id' => 1,
                'module_id' => $i,
                'allow_view' => true,
                'allow_create' => true,
                'allow_edit' => true,
                'allow_delete' => true,
                'allow_extra' => true,
                'allow_master' => true,
            ]);
        }
        DB::table('user')->insert([
            'name' => 'Administrator',
            'role_id' => 1,
            'email' => 'admin@localhost.com',
            'password' => bcrypt('123456'),
            'active' => true
        ]);
    }
}
