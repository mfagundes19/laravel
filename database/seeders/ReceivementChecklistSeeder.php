<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReceivementChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('receivement_checklist')->insert([
            'type' => 'cargo-quality',
            'name' => 'Sem Avarias',
        ]);
        DB::table('receivement_checklist')->insert([
            'type' => 'cargo-quality',
            'name' => 'Embalagem Rasgada',
        ]);
        DB::table('receivement_checklist')->insert([
            'type' => 'cargo-quality',
            'name' => 'Caixa Quebrada',
        ]);
        DB::table('receivement_checklist')->insert([
            'type' => 'cargo-quality',
            'name' => 'Paletes Tombados',
        ]);
        DB::table('receivement_checklist')->insert([
            'type' => 'cargo-quality',
            'name' => 'Carga Molhada',
        ]);
        DB::table('receivement_checklist')->insert([
            'type' => 'restriction',
            'name' => 'Diferença de Peso',
        ]);
        DB::table('receivement_checklist')->insert([
            'type' => 'restriction',
            'name' => 'Diferença de Volume',
        ]);
        DB::table('receivement_checklist')->insert([
            'type' => 'restriction',
            'name' => 'Valor',
        ]);
        DB::table('receivement_checklist')->insert([
            'type' => 'restriction',
            'name' => 'Material',
        ]);
    }
}
