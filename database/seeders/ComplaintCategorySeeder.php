<?php

namespace Database\Seeders;

use App\Models\ComplaintCategory;
use Illuminate\Database\Seeder;

class ComplaintCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Lansia Terlantar / Ditelantarkan', 'is_active' => true],
            ['name' => 'ODGJ Terlantar / Meresahkan Lingkungan', 'is_active' => true],
            ['name' => 'Penyandang Disabilitas Membutuhkan Bantuan Mendesak', 'is_active' => true],
            ['name' => 'Anak Terlantar / Kekerasan pada Anak', 'is_active' => true],
            ['name' => 'Kemiskinan Ekstrem / Kelayakan Bansos', 'is_active' => true],
            ['name' => 'Gelandangan, Pengemis, dan Pengamen Liar', 'is_active' => true],
            ['name' => 'Lainnya / Permasalahan Sosial Umum', 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            ComplaintCategory::firstOrCreate(['name' => $cat['name']], $cat);
        }
    }
}
