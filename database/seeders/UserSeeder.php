<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\User;
use App\Models\Village;
use App\Models\WorkUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        $linjamsos = WorkUnit::where('name', 'like', '%Linjamsos%')->first();
        $rehsos = WorkUnit::where('name', 'like', '%Rehsos%')->first();
        $sekretariat = WorkUnit::where('name', 'like', '%Sekretariat%')->first();

        $kanigoro = District::where('name', 'Kanigoro')->first();
        $desaKanigoro = Village::where('name', 'Kanigoro')->first();

        $users = [
            [
                'name' => 'Administrator Sistem Dinsos',
                'email' => 'admin@blitar.go.id',
                'password' => $password,
                'phone' => '081122334455',
                'work_unit_id' => $sekretariat?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Kepala Dinas Sosial (Kadis)',
                'email' => 'kadis@blitar.go.id',
                'password' => $password,
                'phone' => '081122334456',
                'work_unit_id' => $sekretariat?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Kepala Bidang Linjamsos (Kabid)',
                'email' => 'kabid.linjamsos@blitar.go.id',
                'password' => $password,
                'phone' => '081122334457',
                'work_unit_id' => $linjamsos?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Kepala Bidang Rehsos (Kabid)',
                'email' => 'kabid.rehsos@blitar.go.id',
                'password' => $password,
                'phone' => '081122334458',
                'work_unit_id' => $rehsos?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Petugas Pelayanan & Verifikator',
                'email' => 'petugas.dinsos@blitar.go.id',
                'password' => $password,
                'phone' => '081122334459',
                'work_unit_id' => $linjamsos?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Petugas Rehabilitasi Sosial',
                'email' => 'petugas.rehsos@blitar.go.id',
                'password' => $password,
                'phone' => '081122334460',
                'work_unit_id' => $rehsos?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Operator Kecamatan Kanigoro',
                'email' => 'operator.kanigoro@blitar.go.id',
                'password' => $password,
                'phone' => '081122334461',
                'district_id' => $kanigoro?->id,
                'village_id' => $desaKanigoro?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Warga',
                'email' => 'warga@gmail.com',
                'password' => $password,
                'phone' => '085799887766',
                'nik' => '3505010101950001',
                'district_id' => $kanigoro?->id,
                'village_id' => $desaKanigoro?->id,
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(['email' => $user['email']], $user);
        }
    }
}
