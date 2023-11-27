<?php

namespace App\Imports;

use App\Models\Alternative;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AlternativesImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        // dd($rows);

        $rows = $rows->skip(1);  // Skip the first row (header row)
        foreach ($rows as $row) {
            $name = $row[0]; // Assuming the name is in the first column
            // $initials = $this->generateInitials($name);

            Alternative::updateOrCreate(
                ['name' => $name],
                // ['initials_name' => $initials]
            );
        }
    }

    private function generateInitials($name)
    {
        $words = explode(' ', $name);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return $initials;
    }
}
