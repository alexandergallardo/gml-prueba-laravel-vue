<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();

        DB::table('categories')->insert([
            'name' => 'Cliente',
        ]);
        DB::table('categories')->insert([
            'name' => 'Proveedor',
        ]);
        DB::table('categories')->insert([
            'name' => 'Funcionario Interno',
        ]);
    }
}
