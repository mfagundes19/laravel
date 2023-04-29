<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_method')->insert([
            'name' => 'DINHEIRO'
        ]);
        DB::table('payment_method')->insert([
            'name' => 'CHEQUE'
        ]);
        DB::table('payment_method')->insert([
            'name' => 'BOLETO'
        ]);
        DB::table('payment_method')->insert([
            'name' => 'DEPÓSITO'
        ]);
        DB::table('payment_method')->insert([
            'name' => 'TRANSFERÊNCIA'
        ]);
        DB::table('payment_method')->insert([
            'name' => 'PIX'
        ]);
        DB::table('payment_method')->insert([
            'name' => 'MISTO'
        ]);
    }
}
