<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PaymentTermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_term')->insert([
            'name' => 'Á VISTA'
        ]);
        DB::table('payment_term')->insert([
            'name' => '0/30 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '0/30/45 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '0/30/45/60 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '5 D'
        ]);
        DB::table('payment_method')->insert([
            'name' => '7 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '14 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '21 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '28 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '30 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '35 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '45 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '50 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '28/35 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '35/35/42 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '28/35/42/49 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '28/35/42/49/56 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '30/60 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '30/45/60 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '30/45/60/75 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '30/60/90 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '30/60/90/120 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '45/60 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '45/60/75 D'
        ]);
        DB::table('payment_term')->insert([
            'name' => '45/60/75/90 D'
        ]);
    }
}
