<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BaseSeeder01Jun extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('module')->insert([
            'name' => 'Forma de Pagamento',
            'module' => 'payment_method'
        ]);
        DB::table('module')->insert([
            'name' => 'Transportadoras',
            'module' => 'shipping_company'
        ]);
    }
}
