<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengiriman')->insert([
            'nomor' => 'ak12345bb',
            'pemilik' => 'akaya sapa',
            'resi' => '18210865433',
            'status' => 'terkirim',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
