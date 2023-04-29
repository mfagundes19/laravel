<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PartnerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('receivement_status')->insert([
            'name' => 'Aguardando Descarga',
        ]);
        DB::table('receivement_status')->insert([
            'name' => 'Em Recebimnento',
        ]);
        DB::table('receivement_status')->insert([
            'name' => 'Restrita para Análise',
        ]);
        DB::table('receivement_status')->insert([
            'name' => 'Devolver Carga',
        ]);
        DB::table('receivement_status')->insert([
            'name' => 'Aguardando Inspeção',
        ]);
        DB::table('receivement_status')->insert([
            'name' => 'Recebida',
        ]);
        DB::table('receivement_status')->insert([
            'name' => 'Em Segregação',
        ]);
        DB::table('receivement_status')->insert([
            'name' => 'Segregada',
        ]);
    }
}
