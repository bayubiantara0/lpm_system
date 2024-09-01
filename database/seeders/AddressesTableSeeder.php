<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressesTableSeeder extends Seeder
{
    public function run()
    {
        // Sample data for addresses
        DB::table('addresses')->insert([
            [
                'provinsi' => 'DKI Jakarta',
                'kab_kota' => 'Jakarta Selatan',
                'kecamatan' => 'Kebayoran Baru',
                'kelurahan_desa' => 'Cipete Selatan',
                'alamat' => 'Jl. Melati No. 23',
                'rt' => '01',
                'rw' => '02',
            ],
            [
                'provinsi' => 'Jawa Barat',
                'kab_kota' => 'Bandung',
                'kecamatan' => 'Cicendo',
                'kelurahan_desa' => 'Sukajadi',
                'alamat' => 'Jl. Mawar No. 45',
                'rt' => '03',
                'rw' => '04',
            ],
        ]);
    }
}
