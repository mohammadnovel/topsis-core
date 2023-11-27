<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Transaction;

class SAWController extends Controller
{
    public function getMatrix()
    {
        $alternatives = Alternative::all();
        // dd($alternatives);
        $criteriaNames = Criteria::pluck('name');
        $decisionMatrix = [];

        foreach ($alternatives as $alternative) {
            // $row = ['alternative_id' => $alternative->id, 'alternative_name' => $alternative->name];
            $getCriteria = [];

            foreach ($criteriaNames as $criteriaName) {
                $value = Transaction::where('alternative_id', $alternative->id)
                    ->whereHas('criterias', function ($query) use ($criteriaName) {
                        $query->where('name', $criteriaName);
                    })
                    ->value('value');
    
                $getCriteria[] = $value;
            }

            // $decisionMatrix[] = $row;
            $decisionMatrix[$alternative->id] = [
                'id' => $alternative->id,
                'name' => $alternative->name,
                'values' => $getCriteria,
            ];
        }
        
        // dd($decisionMatrix);
        return $decisionMatrix;
    }

    public function getNormalizedMatrix()
    {
        $decisionMatrix = $this->getMatrix();

        // Inisialisasi matriks normalisasi
        $normalizedMatrix = [];

        // Normalisasi setiap baris
        foreach ($decisionMatrix as $row) {
            $total = array_sum($row['values']);
            $normalizedValues = [];

            foreach ($row['values'] as $value) {
                $normalizedValues[] = $value ? $value / $total : null;
            }

            $normalizedMatrix[$row['id']] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'normalized_values' => $normalizedValues,
            ];
        }
        dd($normalizedMatrix);
        return $normalizedMatrix;
    }

    public function getWeightedMatrix()
    {
        $normalizedMatrix = $this->getNormalizedMatrix();
        $criteriaWeights = Criteria::pluck('weight', 'id')->all();

        // Inisialisasi matriks berbobot
        $weightedMatrix = [];

        // Hitung nilai berbobot untuk setiap baris
        foreach ($normalizedMatrix as $row) {
            $weightedValues = [];

            foreach ($row as $key => $value) {
                if (strpos($key, 'criteria_') !== false) {
                    $criterionId = str_replace('criteria_', '', $key);
                    $weightedValues[$key] = $value ? $value * $criteriaWeights[$criterionId] : null;
                } else {
                    $weightedValues[$key] = $value;
                }
            }

            $weightedMatrix[] = $weightedValues;
        }

        return $weightedMatrix;
    }

    public function getPreferences()
    {
        $weightedMatrix = $this->getWeightedMatrix();

        // Inisialisasi nilai preferensi
        $preferences = [];

        foreach ($weightedMatrix as $row) {
            $preferences[] = array_sum(array_values($row));
        }

        return $preferences;
    }

    public function getRank()
    {
        $preferences = $this->getPreferences();

        // Sorting nilai preferensi untuk mendapatkan peringkat
        arsort($preferences);

        // Inisialisasi peringkat
        $rank = [];

        $i = 1;
        foreach ($preferences as $key => $value) {
            $rank[] = ['rank' => $i, 'alternative_id' => $key + 1, 'preference_value' => $value];
            $i++;
        }

        return $rank;
    }
}
