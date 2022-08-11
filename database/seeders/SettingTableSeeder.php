<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id_setting' => 1,
            'nama_perusahaan' => 'APT Nurul Ilham',
            'alamat' => 'Jl Subang Cidahu',
            'telepon' => '081229990930',
            'tipe_nota' => 1, //kecil
            'path_logo' => '/img/logoo.png',
        ]);
    }
}
