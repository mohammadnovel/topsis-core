<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;
class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $criteriaData = [
            ['name' => 'Kelakuan Baik', 'weight' => 4, 'type' => 'BENEFIT'],
            ['name' => 'Perkara Pidana', 'weight' => 5, 'type' => 'COST'],
            ['name' => 'Masa Pidana', 'weight' => 5, 'type' => 'COST'],
            ['name' => 'Kegiatan Keagamaan', 'weight' => 3, 'type' => 'BENEFIT'],
            ['name' => 'Kegiatan Pelatihan', 'weight' => 3, 'type' => 'BENEFIT'],
            ['name' => 'Kegiatan Kenegaraan', 'weight' => 2, 'type' => 'BENEFIT'],
            ['name' => 'Kegiatan Pendidikan', 'weight' => 3, 'type' => 'BENEFIT'],
        ];

        foreach ($criteriaData as $criteria) {
            Criteria::create([
                'name' => $criteria['name'],
                'weight' => $criteria['weight'],
                'type' => $criteria['type'],
            ]);
        }
    }
}
