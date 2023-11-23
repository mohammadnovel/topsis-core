<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternative;
class AlternativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $alternativeData = [
            'ANDIKA WAHYU SAPUTRA','KOMSIN','HENDRO SANTOSO','MOCH EDI NURYANTO','MOH.RIDWAN FEBRIANTO',
            'SAIFUL SODIK','FERYAN BUDI SANTOSO','AAN YULIANTO','IMAM SOLIKIN','IMAM AZIZ','DENI DWI WAHYUDI',
            'TUKERI','ZAINUL KHOIRI','NURYANTO','SAMSUDIN','FATHUR ROHMAN','NURID','GANGSAR IKHSAN','PURNA IRAWAN',
            'SURYONO',
            'LUFNA ACIK ASMARA DIA ALAGADRI','ISMAIL','SUTRISNO','AGUS SETIAWAN','AMADI',
            'TRIYONO','TRI WIDODO','IMAM FADHOLI','ARIS DWI SATMOKO','BAMBANG WIDODO'
        ];

        foreach ($alternativeData as $alternativeName) {
            Alternative::create([
                'name' => $alternativeName,
            ]);
        }
    }
}
