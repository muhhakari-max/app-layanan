<?php

namespace Database\Seeders;

use App\Models\DtsenPurpose;
use Illuminate\Database\Seeder;

class DtsenPurposeSeeder extends Seeder
{
    public function run(): void
    {
        $purposes = [
            [
                'code' => 'spmb_afirmasi',
                'name' => 'SPMB Jalur Afirmasi (SD / SMP / SMA)',
                'max_decile' => 5,
                'validity_days' => 30,
                'is_active' => true,
            ],
            [
                'code' => 'pip',
                'name' => 'Program Indonesia Pintar (PIP)',
                'max_decile' => 4,
                'validity_days' => 60,
                'is_active' => true,
            ],
            [
                'code' => 'kip_kuliah',
                'name' => 'KIP Kuliah / Beasiswa Mahasiswa',
                'max_decile' => 4,
                'validity_days' => 90,
                'is_active' => true,
            ],
            [
                'code' => 'bansos_pemerintah',
                'name' => 'Bantuan Sosial Daerah / Provinsi',
                'max_decile' => 3,
                'validity_days' => 30,
                'is_active' => true,
            ],
            [
                'code' => 'kesehatan_sktm',
                'name' => 'Pelayanan Kesehatan / Keringanan Biaya Medis',
                'max_decile' => 4,
                'validity_days' => 30,
                'is_active' => true,
            ],
            [
                'code' => 'lainnya',
                'name' => 'Keperluan Lainnya yang Sah',
                'max_decile' => 5,
                'validity_days' => 30,
                'is_active' => true,
            ],
        ];

        foreach ($purposes as $purpose) {
            DtsenPurpose::firstOrCreate(['code' => $purpose['code']], $purpose);
        }
    }
}
