<?php

namespace Database\Seeders;

use App\Enums\ServiceHandler;
use App\Models\ServiceRequirement;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'code' => 'DTSEN',
                'name' => 'Surat Keterangan DTSEN',
                'category' => 'Pelayanan Surat Rekomendasi',
                'description' => 'Penerbitan surat keterangan status seseorang/keluarga dalam Data Tunggal Sosial Ekonomi Nasional (DTSEN) beserta peringkat desil untuk keperluan SPMB jalur afirmasi, PIP, KIP Kuliah, dan bantuan sosial.',
                'handler' => ServiceHandler::Dtsen,
                'needs_assessment' => false,
                'sla_days' => 2,
                'is_active' => true,
                'requirements' => [
                    ['name' => 'Kartu Tanda Penduduk (KTP) Pemohon', 'is_mandatory' => true, 'allowed_mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 1],
                    ['name' => 'Kartu Keluarga (KK) Kabupaten Blitar', 'is_mandatory' => true, 'allowed_mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 2],
                    ['name' => 'Dokumen Pendukung / Surat Pengantar Sekolah/Kampus', 'is_mandatory' => false, 'allowed_mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 3],
                ],
            ],
            [
                'code' => 'PBI',
                'name' => 'Reaktivasi KIS / PBI-JK',
                'category' => 'Jaminan Kesehatan Sosial',
                'description' => 'Fasilitasi pengaktifan kembali kepesertaan JKN-KIS Penerima Bantuan Iuran Jaminan Kesehatan (PBI-JK) yang dinonaktifkan oleh Kementerian Sosial.',
                'handler' => ServiceHandler::Pbi,
                'needs_assessment' => false,
                'sla_days' => 3,
                'is_active' => true,
                'requirements' => [
                    ['name' => 'Kartu Tanda Penduduk (KTP) Peserta', 'is_mandatory' => true, 'allowed_mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 1],
                    ['name' => 'Kartu Keluarga (KK)', 'is_mandatory' => true, 'allowed_mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 2],
                    ['name' => 'Kartu BPJS Kesehatan / KIS Nonaktif', 'is_mandatory' => true, 'allowed_mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 3],
                    ['name' => 'Surat Keterangan Rawat/Medis dari Fasilitas Kesehatan (RS/Puskesmas)', 'is_mandatory' => false, 'allowed_mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 4],
                ],
            ],
            [
                'code' => 'REHSOS',
                'name' => 'Permohonan Rehabilitasi Sosial',
                'category' => 'Rehabilitasi Sosial',
                'description' => 'Permohonan penanganan rehabilitasi sosial bagi Pemerlu Pelayanan Kesejahteraan Sosial (PPKS) seperti lansia terlantar, disabilitas berat, dan ODGJ.',
                'handler' => ServiceHandler::Generic,
                'needs_assessment' => true,
                'sla_days' => 7,
                'is_active' => true,
                'requirements' => [
                    ['name' => 'KTP / Identitas Klien / Pelapor', 'is_mandatory' => false, 'allowed_mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 1],
                    ['name' => 'Foto Kondisi Klien Terkini', 'is_mandatory' => true, 'allowed_mimes' => 'jpg,jpeg,png', 'sort_order' => 2],
                    ['name' => 'Surat Pengantar Desa / Kelurahan', 'is_mandatory' => false, 'allowed_mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 3],
                ],
            ],
            [
                'code' => 'BANSOS',
                'name' => 'Rekomendasi Bantuan Sosial Terpadu',
                'category' => 'Bantuan Sosial',
                'description' => 'Permohonan rekomendasi bantuan sosial terpadu atau bantuan darurat kemiskinan ekstrem.',
                'handler' => ServiceHandler::Generic,
                'needs_assessment' => false,
                'sla_days' => 3,
                'is_active' => true,
                'requirements' => [
                    ['name' => 'KTP Pemohon', 'is_mandatory' => true, 'allowed_mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 1],
                    ['name' => 'Kartu Keluarga (KK)', 'is_mandatory' => true, 'allowed_mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 2],
                    ['name' => 'Surat Keterangan Tidak Mampu (SKTM) dari Desa', 'is_mandatory' => true, 'allowed_mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 3],
                    ['name' => 'Foto Kondisi Rumah / Tempat Tinggal', 'is_mandatory' => true, 'allowed_mimes' => 'jpg,jpeg,png', 'sort_order' => 4],
                ],
            ],
        ];

        foreach ($types as $tData) {
            $requirements = $tData['requirements'];
            unset($tData['requirements']);

            $serviceType = ServiceType::firstOrCreate(
                ['code' => $tData['code']],
                $tData
            );

            foreach ($requirements as $req) {
                ServiceRequirement::firstOrCreate(
                    [
                        'service_type_id' => $serviceType->id,
                        'name' => $req['name'],
                    ],
                    $req
                );
            }
        }
    }
}
