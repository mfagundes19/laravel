<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {     
        /*   
        DB::table('module')->insert([
            'name' => 'Unidades',
            'module' => 'branch',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]); 
        DB::table('module')->insert([    //6
            'name' => 'Tipos de Operação',
            'module' => 'operation-type',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
        DB::table('module')->insert([    //12
            'name' => 'Coloração',
            'module' => 'color',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
        DB::table('menu')->insert([
            'module_id' => 5,
            'name' => 'Unidades',
            'link' => 'branches',
            'nivel' => 2,
            'nivel_1_menu_id' => 1
        ]);*/

        DB::table('module')->insert([    //7
            'name' => 'Tipos de Apara',
            'module' => 'shaving-type',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]); 
        DB::table('module')->insert([
            'name' => 'Segragadores',
            'module' => 'segregator',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
        DB::table('module')->insert([ 
            'name' => 'Qualidade de Carga',
            'module' => 'cargo-quality',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
        DB::table('module')->insert([
            'name' => 'Tipos de Vasilhame',
            'module' => 'container-type',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
        DB::table('module')->insert([   
            'name' => 'Produtos Categorias',
            'module' => 'product-category',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
        DB::table('module')->insert([   
            'name' => 'Produtos Tipo',
            'module' => 'product-type',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
        DB::table('module')->insert([   
            'name' => 'Fornecedores Categorias',
            'module' => 'supplier-category',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
        DB::table('module')->insert([ 
            'name' => 'Fornecedores',
            'module' => 'supplier',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
        DB::table('module')->insert([ 
            'name' => 'Status Fiscal',
            'module' => 'fiscal_status',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
        DB::table('module')->insert([ 
            'name' => 'Status de Segragação',
            'module' => 'segregation_status',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
        DB::table('module')->insert([ 
            'name' => 'P. Recebimento',
            'module' => 'receipt-plan',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
        DB::table('module')->insert([ 
            'name' => 'Recebimento',
            'module' => 'receipt',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
    }
}
