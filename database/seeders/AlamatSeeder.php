<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('alamats')->insert([
            [
                'provinsi_id' => 1,
                'kabupaten_id'=> 1,
                "kecamatan_id"=>1,
                "kelurahan_id"=>1,
                'alamat_detail'=>"Tegallayang, caturharjo, pandak, bantul",
                "kode_pos"=>"55761",
                "user_id"=>14,
            ],
            [
                'provinsi_id' => 1,
                'kabupaten_id'=> 1,
                "kecamatan_id"=>1,
                "kelurahan_id"=>1,
                'alamat_detail'=>"Tegallayang, caturharjo, pandak, bantul",
                "kode_pos"=>"55761",
                "user_id"=>15,
            ],
            [
                'provinsi_id' => 1,
                'kabupaten_id'=> 1,
                "kecamatan_id"=>1,
                "kelurahan_id"=>1,
                'alamat_detail'=>"Tegallayang, caturharjo, pandak, bantul",
                "kode_pos"=>"55761",
                "user_id"=>16,
            ],

        ]);
    }
}
