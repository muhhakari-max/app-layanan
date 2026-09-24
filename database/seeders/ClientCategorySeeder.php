<?php

namespace Database\Seeders;

use App\Models\ClientCategory;
use Illuminate\Database\Seeder;

class ClientCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Lansia Terlantar', 'description' => 'Lanjut usia terlantar tanpa keluarga yang mengurus', 'is_active' => true],
            ['name' => 'Penyandang Disabilitas Terlantar', 'description' => 'Penyandang disabilitas fisik/mental terlantar', 'is_active' => true],
            ['name' => 'Orang Dengan Gangguan Jiwa (ODGJ) Terlantar', 'description' => 'ODGJ di tempat umum atau butuh penanganan medis/rujukan', 'is_active' => true],
            ['name' => 'Anak Terlantar / Berhadapan dengan Hukum', 'description' => 'Anak terlantar atau korban kekerasan', 'is_active' => true],
            ['name' => 'Korban Tindak Kekerasan / Trafiking', 'description' => 'Korban kekerasan dalam rumah tangga atau perdagangan orang', 'is_active' => true],
            ['name' => 'Gelandangan dan Pengemis (Gepeng)', 'description' => 'Pemerlu penertiban dan pembinaan sosial', 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            ClientCategory::firstOrCreate(['name' => $cat['name']], $cat);
        }
    }
}
