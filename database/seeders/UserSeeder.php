<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => "customer@gmail.com",
                'email'=> "customer@gmail.com",
                "password"=>Hash::make("customer@gmail.com"),
                "no_hp"=>"08956448972",
                'role_id'=>1
            ],
            [
                'name' => "Samuel Simanjuntak",
                'email'=> "manajer@gmail.com",
                "password"=>Hash::make("manajer@gmail.com"),
                "no_hp"=>"08956448973",
                'role_id'=>3
            ],
            [
                'name' => "Lonzo Ball",
                'email'=> "cs@gmail.com",
                "password"=>Hash::make("cs@gmail.com"),
                "no_hp"=>"08956448974",
                'role_id'=>2
            ],
        ]);
    }
}
