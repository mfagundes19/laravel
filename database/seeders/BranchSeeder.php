<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branch')->insert([
            'name' => 'CETENÁRIO'
        ]);
        DB::table('branch')->insert([
            'name' => 'MATRIZ'
        ]);
        DB::table('branch')->insert([
            'name' => 'RECPLUS'
        ]);
    }
}
