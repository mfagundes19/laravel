<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ShippingCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_company')->insert([
            'company' => 'COMAN',
            'name' => 'COMAN'

        ]);
        DB::table('shipping_company')->insert([
            'company' => 'GB PACHECO / GIL',
            'name' => 'GB PACHECO / GIL'
        ]);
        DB::table('shipping_company')->insert([
            'company' => 'LUIS FERNANDO',
            'name' => 'LUIS FERNANDO'
        ]);
        DB::table('shipping_company')->insert([
            'company' => 'MARCIO WEBBER',
            'name' => 'MARCIO WEBBER'
        ]);
    }
}
