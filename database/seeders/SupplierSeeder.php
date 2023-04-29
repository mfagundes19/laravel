<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('supplier')->insert([
            'company' => 'A.D KERSTING - ME',
            'name' => 'A.D KERSTING - ME'
        ]);
        DB::table('supplier')->insert([
            'company' => 'ADM RECICLA',
            'name' => 'ADM RECICLA'
        ]);
        DB::table('supplier')->insert([
            'company' => ' AGROPLAST',
            'name' => ' AGROPLAST'
        ]);
        DB::table('supplier')->insert([
            'company' => 'ADILSO',
            'name' => 'ADILSO'
        ]);
        DB::table('supplier')->insert([
            'company' => 'ALUCEK',
            'name' => 'ALUCEK'
        ]);
        DB::table('supplier')->insert([
            'company' => 'ANA PAULA MOSER',
            'name' => 'ANA PAULA MOSER'
        ]);
        DB::table('supplier')->insert([
            'company' => 'AMARILDO',
            'name' => 'AMARILDO'
        ]);
        DB::table('supplier')->insert([
            'company' => 'BOMBER',
            'name' => 'BOMBER'
        ]);
        DB::table('supplier')->insert([
            'company' => 'ALUCEK',
            'name' => 'ALUCEK'
        ]);
        DB::table('supplier')->insert([
            'company' => 'BRASLUX',
            'name' => 'BRASLUX'
        ]);
        DB::table('supplier')->insert([
            'company' => 'BRISTOL',
            'name' => 'BRISTOL'
        ]);
        DB::table('supplier')->insert([
            'company' => 'BIOTEC POLIMEROS',
            'name' => 'BIOTEC POLIMEROS'
        ]);
        DB::table('supplier')->insert([
            'company' => 'CARLOS DE BORBA',
            'name' => 'CARLOS DE BORBA'
        ]);
        DB::table('supplier')->insert([
            'company' => 'CCF IND. COMP',
            'name' => 'CCF IND. COMP'
        ]);
        DB::table('supplier')->insert([
            'company' => 'CENTENÁRIO - UPA',
            'name' => 'CENTENÁRIO - UPA'
        ]);
        DB::table('supplier')->insert([
            'company' => 'CEK',
            'name' => 'CEK'
        ]);
        DB::table('supplier')->insert([
            'company' => 'CICLOPLAST',
            'name' => 'CICLOPLAST'
        ]);

        DB::table('supplier')->insert([
            'company' => 'COPLAST',
            'name' => 'COPLAST'
        ]);
        DB::table('supplier')->insert([
            'company' => 'CLAUDIO',
            'name' => 'CLAUDIO'
        ]);
        DB::table('supplier')->insert([
            'company' => 'CONCLUSÃO',
            'name' => 'CONCLUSÃO'
        ]);
        DB::table('supplier')->insert([
            'company' => 'COOTRACAR',
            'name' => 'COOTRACAR'
        ]);
        DB::table('supplier')->insert([
            'company' => 'CORTECH',
            'name' => 'CORTECH'
        ]);
    }
}
