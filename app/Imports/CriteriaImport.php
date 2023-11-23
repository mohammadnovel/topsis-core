<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Criteria;
class CriteriaImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $name = $row[0]; // Assuming name is in the first column
            $type = $row[1]; // Assuming type is in the second column
            $weight = $row[2]; // Assuming weight is in the third column

            Criteria::updateOrCreate(
                ['name' => $name],
                ['type' => $type, 'weight' => $weight]
            );
        }
    }
}
