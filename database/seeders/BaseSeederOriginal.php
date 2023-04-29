<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BaseSeederOriginal extends Seeder
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
            'module' => 'modules'
        ]);
        DB::table('module')->insert([    ///2
            'name' => 'Menu',
            'module' => 'menu'
        ]);
        DB::table('module')->insert([    //3
            'name' => 'Usuários',
            'module' => 'users'
        ]);
        DB::table('module')->insert([    //4
            'name' => 'Perfil',
            'module' => 'roles'
        ]); 
        DB::table('module')->insert([    //5
            'name' => 'Unidades',
            'module' => 'branches'
        ]); 
        DB::table('module')->insert([    //6
            'name' => 'Tipos de Operação',
            'module' => 'operation-types'
        ]);
        DB::table('module')->insert([    //7
            'name' => 'Tipos de Apara',
            'module' => 'shaving-types'
        ]); 
        DB::table('module')->insert([    //8
            'name' => 'Restrições',
            'module' => 'restrictions'
        ]);
        DB::table('module')->insert([    //9
            'name' => 'Destinos',
            'module' => 'destinations'
        ]); 
        DB::table('module')->insert([    //10
            'name' => 'Destino Restrito',
            'module' => 'restricted-destinations'
        ]);
        DB::table('module')->insert([    //11
            'name' => 'Segragadores',
            'module' => 'segregators'
        ]);
        DB::table('module')->insert([    //12
            'name' => 'Coloração',
            'module' => 'colors'
        ]);
        DB::table('module')->insert([    //13
            'name' => 'Qualidade de Carga',
            'module' => 'cargo-qualities'
        ]);
        DB::table('module')->insert([    //14
            'name' => 'Tipos de Vasilhame',
            'module' => 'container-types'
        ]);
        DB::table('module')->insert([    //15
            'name' => 'Densidades',
            'module' => 'densities'
        ]);
        DB::table('module')->insert([    //16
            'name' => 'Qualificação do Produto',
            'module' => 'product-qualifications'
        ]);
        DB::table('module')->insert([    //17
            'name' => 'Famílias (Produtos)',
            'module' => 'products-categories'
        ]);
        DB::table('module')->insert([    //18
            'name' => 'Classes (Fornecedores)',
            'module' => 'suppliers-categories'
        ]);
        DB::table('module')->insert([    //19
            'name' => 'Fornecedores',
            'module' => 'suppliers'
        ]);
        DB::table('module')->insert([    //20
            'name' => 'P. Recebimento Status',
            'module' => 'receipt-plans-status'
        ]);
        DB::table('module')->insert([    //21
            'name' => 'P. Recebimento',
            'module' => 'receipt-plans-status'
        ]);


        DB::table('menu')->insert([       //1
            'module_id' => null,
            'name' => 'Configuração',
            'link' => '',
            'nivel' => 1
        ]);     
        DB::table('menu')->insert([       //2
            'module_id' => null,
            'name' => 'Sistema',
            'link' => '',
            'nivel' => 1
        ]);    
        DB::table('menu')->insert([       //3
            'module_id' => null,
            'name' => 'Cadastros',
            'link' => '',
            'nivel' => 1
        ]);      
        DB::table('menu')->insert([       //4
            'module_id' => null,
            'name' => 'Operacional',
            'link' => '',
            'nivel' => 1
        ]);  

        DB::table('menu')->insert([
            'module_id' => 1,
            'name' => 'Módulos',
            'link' => 'modules',
            'nivel' => 2,
            'nivel_1_menu_id' => 1
        ]);
        DB::table('menu')->insert([
            'module_id' => 2,
            'name' => 'Menu',
            'link' => 'menu',
            'nivel' => 2,
            'nivel_1_menu_id' => 1
        ]);
        DB::table('menu')->insert([
            'module_id' => 3,
            'name' => 'Usuários',
            'link' => 'users',
            'nivel' => 2,
            'nivel_1_menu_id' => 2
        ]);
        DB::table('menu')->insert([
            'module_id' => 4,
            'name' => 'Perfil',
            'link' => 'roles',
            'nivel' => 2,
            'nivel_1_menu_id' => 2
        ]);
        DB::table('menu')->insert([
            'module_id' => 5,
            'name' => 'Unidades',
            'link' => 'branches',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 6,
            'name' => 'Tipos de Operação',
            'link' => 'operation-types',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 7,
            'name' => 'Tipos de Apara',
            'link' => 'shaving-types',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 8,
            'name' => 'Restrições',
            'link' => 'restrictions',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 9,
            'name' => 'Destinos',
            'link' => 'destinations',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 10,
            'name' => 'Destino Restrito',
            'link' => 'restricted-destinations',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 11,
            'name' => 'Segragadores',
            'link' => 'segregators',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 12,
            'name' => 'Cores',
            'link' => 'colors',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 13,
            'name' => 'Qualidade de Carga',
            'link' => 'cargo-qualities',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 14,
            'name' => 'Tipos de Vasilhames',
            'link' => 'container-types',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 15,
            'name' => 'Densidades',
            'link' => 'densities',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 16,
            'name' => 'Qualificação do Produto',
            'link' => 'product-qualifications',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 17,
            'name' => 'Famílias',
            'link' => 'products-categories',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 18,
            'name' => 'Classes',
            'link' => 'suppliers-categories',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('menu')->insert([
            'module_id' => 19,
            'name' => 'Fornecedores',
            'link' => 'suppliers',
            'nivel' => 2,
            'nivel_1_menu_id' => 3
        ]);
        DB::table('roles')->insert([
            'name' => 'Administrator'
        ]);
        for($i=1; $i <= 21; $i++) {
            DB::table('roles_permissions')->insert([
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

        DB::table('users')->insert([
            'name' => 'Administrator',
            'role_id' => 1,
            'email' => 'admin@localhost.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
