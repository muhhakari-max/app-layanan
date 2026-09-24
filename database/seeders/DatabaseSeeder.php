<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            WorkUnitSeeder::class,
            DistrictVillageSeeder::class,
            ServiceTypeSeeder::class,
            DtsenPurposeSeeder::class,
            ClientCategorySeeder::class,
            ReferralInstitutionSeeder::class,
            ComplaintCategorySeeder::class,
            UserSeeder::class,
        ]);
    }
}
