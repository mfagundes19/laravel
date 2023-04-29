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
        DB::table('module')->insert([
            'name' => 'Unidades',
            'module' => 'branches',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]); 

        DB::table('menu')->insert([
            'module_id' => 5,
            'name' => 'Unidades',
            'link' => 'branches',
            'nivel' => 2,
            'nivel_1_menu_id' => 1
        ]);







        
    }
}
