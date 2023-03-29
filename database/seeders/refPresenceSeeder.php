<?php

namespace Database\Seeders;

use App\Models\RefPresent;
use Illuminate\Database\Seeder;

class refPresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RefPresent::query()->insertOrIgnore([
            [
                'id' => 1,
                'libelle_fr' => 'present',
                'libelle_ar' => 'حاضر',
                'ordre' => 1,
            ],
            [
                'id' => 2,
                'libelle_fr' => 'absent',
                'libelle_ar' => 'غائب',
                'ordre' => 2,
            ],
            [
                'id' => 3,
                'libelle_fr' => 'absente justifier',
                'libelle_ar' => 'غياب مبرر',
                'ordre' => 3,
            ]


        ]);

    }
}
