<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Transaction;
use App\Models\Alternative;
use App\Models\Criteria;
use Illuminate\Support\Facades\Log;

class TransactionImport implements ToModel
{
    private $criteriaNames;

    public function __construct(array $criteriaNames)
    {
        $this->criteriaNames = $criteriaNames;
    }

    public function model(array $row)
    {
        $alternativeName = array_shift($row);

        $alternative = Alternative::where('name', $alternativeName)->first();

        if ($alternative) {
            $alternativeId = $alternative->id;

            $transactions = [];
            foreach ($this->criteriaNames as $index => $criteriaName) {
                $criteria = Criteria::where('name', $criteriaName)->first();

                if ($criteria) {
                    $criteriaId = $criteria->id;
                    $value = $row[$index];

                    // Create a new Transaction instance
                    $transactions[] = new Transaction([
                        'alternative_id' => $alternativeId,
                        'criteria_id' => $criteriaId,
                        'value' => $value,
                    ]);
                } else {
                    // Handle the case where the criteria is not found
                    Log::error("Criteria not found: $criteriaName");
                }
            }

            return $transactions;
        }

        // Alternative not found, return null to skip creating a transaction
        return null;
    }
}
