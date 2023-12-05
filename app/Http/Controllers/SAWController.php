<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Transaction;

class SAWController extends Controller
{
    public function SAW() {
        $matrix = $this->getMatrix();
        $getSumMatrix = $this->getSumMatrix();
        $normalizedMatrix = $this->getSumMatrixNormalized();
        $weightedNormalized = $this->NormalizeWeighted();
        $reference = $this->getPrefrence();
        $rankedReference = $this->rankReference();
        $criterias = Criteria::all();
        // dd($rankedReference);
        return view('saw-results', 
            compact([
                'matrix',
                'getSumMatrix',
                'normalizedMatrix',
                'weightedNormalized',
                'reference',
                'rankedReference',
                'criterias'
            ])
        ); 
    }
    private function getMatrix()
    {
        $alternatives = Alternative::all();
        $criteriaNames = Criteria::all();
        $decisionMatrix = [];

        foreach ($alternatives as $alternative) {
            $getCriteria = [];

            foreach ($criteriaNames as $criteriaName) {
                $value = Transaction::where('alternative_id', $alternative->id)
                    ->whereHas('criterias', function ($query) use ($criteriaName) {
                        $query->where('name', $criteriaName->name);
                    })
                    ->value('value');
    
                $getCriteria[] = [
                    'criteria_id' => $criteriaName->id,
                    'type' => $criteriaName->type,
                    'value' => ($value != null ? $value : 0)
                ];
            }

            $decisionMatrix[$alternative->id] = [
                'id' => $alternative->id,
                'name' => $alternative->name,
                'values' => $getCriteria,
            ];
        }
        // dd($decisionMatrix);
        return $decisionMatrix;
    }

    private function getSumMatrix()
    {
        $decisionMatrix = $this->getMatrix();
        $sumMatrix = [];
        foreach ($decisionMatrix as $item) {
            foreach ($item['values'] as $criteria) {
                $criteriaId = $criteria['criteria_id'];
                $value = floatval($criteria['value']);

                if ($criteria['type'] == 'BENEFIT') {
                    $sumMatrix[$criteriaId] = isset($sumMatrix[$criteriaId])
                        ? max($sumMatrix[$criteriaId], floatval($value))
                        : floatval($value);
                } elseif ($criteria['type'] == 'COST') {
                    $sumMatrix[$criteriaId] = isset($sumMatrix[$criteriaId])
                        ? min($sumMatrix[$criteriaId], floatval($value))
                        : floatval($value);
                }
            }
        }

        return $sumMatrix;
    }

    private function getSumMatrixNormalized() {
        $decisionMatrix = $this->getMatrix();
        $sumMatrix = $this->getSumMatrix();
        // Proses pembagian nilai
        $result = [];
        foreach ($decisionMatrix as $matrix) {
            $getResult = [];
            foreach ($matrix['values'] as &$value) {
                $criteriaId = $value['criteria_id'];
                $divisionResult = floatval($value['value']) / floatval($sumMatrix[$criteriaId]);
            
                $value['value'] = round($divisionResult, 4);
            
                $getResult[] = [
                    'criteria_id' => $criteriaId,
                    'type' => $value['type'],
                    'value' => $value['value']
                ];
            }
            // dd($getResult);
            $result[$matrix['id']] = [
                'id' => $matrix['id'],
                'name' => $matrix['name'],
                'values' => $getResult
            ];
        }
        return $result;
        // dd($result);
    }

    private function NormalizeWeighted() {
        $dataMatrix = $this->getSumMatrixNormalized();
        // $criterias = Criteria::all();
        // dd($criterias);
        $result = [];
        foreach ($dataMatrix as $matrix) {
            $resultWeighted = [];
            foreach ($matrix['values'] as $item) {
                $criteriaId = $item['criteria_id'];

                // Find the corresponding criteria data
                $criteria = Criteria::where('id', $criteriaId)->first();
                // dd($criteria);
                $weight = floatval($criteria['weight']);
                $multipliedValue = floatval($item['value']) * $weight;

                $resultWeighted[] = [
                    'criteria_id' => $criteriaId,
                    'type' => $item['type'],
                    'value' => round($multipliedValue, 2)
                ];
            }
            $result[$matrix['id']] = [
                'id' => $matrix['id'],
                'name' => $matrix['name'],
                'values' => $resultWeighted
            ];
        }
        // dd($result);
        return $result;
    }
    
    private function getPrefrence() {
        $decisionMatrix = $this->NormalizeWeighted();

        $sumByAlternative = [];

        foreach ($decisionMatrix as $matrix) {
            $alternativeId = $matrix['id'];
            $sumValues = 0;  // Initialize sum for each alternative_id
        
            foreach ($matrix['values'] as $value) {
                $sumValues += floatval($value['value']);
            }
        
            $sumByAlternative[$alternativeId] = [
                'alternative_id' => $alternativeId,
                'name' => $matrix['name'],
                'values' => $matrix['values'],
                'result' => round($sumValues, 2),
            ];
        }

        return $sumByAlternative;
    }

    private function rankReference() {
        $resultPreference = $this->getPrefrence();
        // Sort results by the 'result' key in descending order
        usort($resultPreference, function ($a, $b) {
            return $b['result'] <=> $a['result'];
        });

        // Add rank
        $rank = 1;
        foreach ($resultPreference as &$result) {
            $result['rank'] = $rank++;
        }
        // dd($resultPreference);
        return $resultPreference;
    }
}
