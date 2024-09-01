<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalDataTableSeeder extends Seeder
{
    public function run()
    {
        // Sample data for personal_data
        DB::table('personal_data')->insert([
            [
                'nama' => 'Budi Santoso',
                'nik' => 3201010101010001,
                'nomor_kartu_keluarga' => 3201010101010001,
                'foto_ktp_path' => 'uploads/ktp/budi.jpg',
                'foto_kartu_keluarga_path' => 'uploads/kk/budi.jpg',
                'umur' => 30,
                'jenis_kelamin' => 'Laki-laki',
                'address_id' => 1, // Assuming this references the first address entry
                'penghasilan_sebelum_pandemi' => 10000000,
                'penghasilan_setelah_pandemi' => 5000000,
                'alasan_membutuhkan_bantuan' => 'Kehilangan pekerjaan',
            ],
            [
                'nama' => 'Siti Aminah',
                'nik' => 3201010101010002,
                'nomor_kartu_keluarga' => 3201010101010002,
                'foto_ktp_path' => 'uploads/ktp/siti.jpg',
                'foto_kartu_keluarga_path' => 'uploads/kk/siti.jpg',
                'umur' => 28,
                'jenis_kelamin' => 'Perempuan',
                'address_id' => 2, // Assuming this references the second address entry
                'penghasilan_sebelum_pandemi' => 8000000,
                'penghasilan_setelah_pandemi' => 4000000,
                'alasan_membutuhkan_bantuan' => 'Kepala keluarga',
            ],
        ]);
    }
}
