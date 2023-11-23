<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Criteria;

class CriteriaImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Assuming $row[0] is the name, $row[1] is the weight, and $row[2] is the type
            $name = $row[0];
            $weight = $row[1];
            $type = strtoupper($row[2]); // Ensure uppercase for type

            // Validate the type
            $validator = Validator::make(['type' => $type], [
                'type' => Rule::in(['BENEFIT', 'COST']),
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                // Handle the validation error, e.g., log it, skip the record, or throw an exception.
                continue;
            }

            // Continue with the updateOrCreate logic
            Criteria::updateOrCreate(
                ['name' => $name],
                ['type' => $type, 'weight' => $weight]
            );
        }
    }
}
