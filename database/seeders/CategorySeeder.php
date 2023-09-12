<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'nama_category' => "T-shirt",
            ],
            [
                'nama_category' => "Jacket",
            ],
            [
                'nama_category' => "Pants",
            ],
            [
                'nama_category' => "Sweater",
            ]
        ]);
        
    }
}
