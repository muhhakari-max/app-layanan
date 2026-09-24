<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Village;
use Illuminate\Database\Seeder;

class DistrictVillageSeeder extends Seeder
{
    public function run(): void
    {
        $districts = [
            [
                'code' => '3505010',
                'name' => 'Kanigoro',
                'villages' => ['Kanigoro', 'Satreyan', 'Tlogo', 'Gaprang', 'Gogodeso', 'Jatinom', 'Kuniran', 'Minggirsari', 'Papungan', 'Sawentar', 'Banggle'],
            ],
            [
                'code' => '3505020',
                'name' => 'Wlingi',
                'villages' => ['Wlingi', 'Babadan', 'Beru', 'Klemunan', 'Tangkil', 'Balerejo', 'Ngadirenggo', 'Tegalasri', 'Tembalang'],
            ],
            [
                'code' => '3505030',
                'name' => 'Garum',
                'villages' => ['Garum', 'Bence', 'Tawangsari', 'Sumberdiren', 'Karanganyar', 'Pojok', 'Sidodadi', 'Slorok', 'Tingal'],
            ],
            [
                'code' => '3505040',
                'name' => 'Sutojayan',
                'villages' => ['Sutojayan', 'Jingglong', 'Kalipang', 'Kedungbunder', 'Kembangarum', 'Sukorejo', 'Pandanyarum', 'Bacem'],
            ],
            [
                'code' => '3505050',
                'name' => 'Talun',
                'villages' => ['Talun', 'Bajang', 'Bendosewu', 'Duren', 'Jajar', 'Kamulan', 'Kendalrejo', 'Pasirharjo', 'Sragi', 'Tumpang', 'Wonorejo'],
            ],
            [
                'code' => '3505060',
                'name' => 'Srengat',
                'villages' => ['Srengat', 'Dandong', 'Kauman', 'Togogan', 'Bagelenan', 'Derso', 'Karanggayam', 'Kendengsari', 'Kragan', 'Ngaglik', 'Purwokerto', 'Selokajang', 'Wonorejo'],
            ],
            [
                'code' => '3505070',
                'name' => 'Sanankulon',
                'villages' => ['Sanankulon', 'Bendowulung', 'Gleduk', 'Jatisari', 'Kalipucang', 'Plosoarang', 'Purworejo', 'Sumber', 'Sumberjo', 'Tuliskriyo'],
            ],
            [
                'code' => '3505080',
                'name' => 'Kesamben',
                'villages' => ['Kesamben', 'Bumiayu', 'Jugobaru', 'Pagergunung', 'Pagerwojo', 'Siraman', 'Sukoanyar', 'Tapakrejo', 'Wonoagung'],
            ],
            [
                'code' => '3505090',
                'name' => 'Gandusari',
                'villages' => ['Gandusari', 'Butun', 'Gadang', 'Kotes', 'Krisik', 'Ngaringan', 'Semisir', 'Slumbung', 'Sukosewu', 'Sumberagung', 'Tambakan', 'Tulungrejo'],
            ],
        ];

        foreach ($districts as $dData) {
            $district = District::firstOrCreate(
                ['code' => $dData['code']],
                ['name' => $dData['name']]
            );

            foreach ($dData['villages'] as $index => $vName) {
                $vCode = $dData['code'] . str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT);
                Village::firstOrCreate(
                    ['code' => $vCode],
                    [
                        'district_id' => $district->id,
                        'name' => $vName,
                    ]
                );
            }
        }
    }
}
