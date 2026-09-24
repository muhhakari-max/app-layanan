<?php

namespace Database\Seeders;

use App\Models\ReferralInstitution;
use Illuminate\Database\Seeder;

class ReferralInstitutionSeeder extends Seeder
{
    public function run(): void
    {
        $institutions = [
            [
                'name' => 'UPTD Balai Pelayanan Sosial Tresna Werdha (BPSTW) Blitar',
                'type' => 'panti',
                'address' => 'Jl. Banteng Blorok, Garum, Kabupaten Blitar',
                'contact' => '(0342) 801234',
                'is_active' => true,
            ],
            [
                'name' => 'RSUD Ngudi Waluyo Wlingi',
                'type' => 'RS',
                'address' => 'Jl. Dokter Sucipto No.5, Beru, Wlingi, Kabupaten Blitar',
                'contact' => '(0342) 691006',
                'is_active' => true,
            ],
            [
                'name' => 'RSJ Menur Surabaya (Rujukan Jiwa/ODGJ Berat)',
                'type' => 'RS',
                'address' => 'Jl. Menur No.120, Surabaya',
                'contact' => '(031) 5021635',
                'is_active' => true,
            ],
            [
                'name' => 'Panti Rehabilitasi Sosial Bina Netra & Rungu Wicara Malang',
                'type' => 'balai',
                'address' => 'Malang, Jawa Timur',
                'contact' => '(0341) 491234',
                'is_active' => true,
            ],
            [
                'name' => 'LKS Kasih Ibu Sejahtera Kabupaten Blitar',
                'type' => 'LKS',
                'address' => 'Kanigoro, Kabupaten Blitar',
                'contact' => '081233445566',
                'is_active' => true,
            ],
        ];

        foreach ($institutions as $inst) {
            ReferralInstitution::firstOrCreate(['name' => $inst['name']], $inst);
        }
    }
}
