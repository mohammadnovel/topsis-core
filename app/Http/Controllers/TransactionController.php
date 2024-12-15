<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\Alternative;
use App\Models\Transaction;

use App\Imports\TransactionImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use DataTables,Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
class TransactionController extends Controller
{
    public function index()
    {
        $alternatives = Alternative::all();
        $criterias = Criteria::all();
        // dd($criterias);
        return view('transaction.index', compact('alternatives', 'criterias'));
    }

    public function getTransactionList(Request $request)
    {
        
        $data  = Transaction::with(['criterias','alternatives'])->get();

        return Datatables::of($data)
                
                ->addColumn('action', function($data){
                    if($data->name == 'Super Admin'){
                        return '';
                    }
                    if (Auth::user()->can('manage_transaction')){
                        return '<div class="table-actions">
                                <a href="#" data-bs-toggle="modal" onClick="ShowModalEdit(' . $data->alternative_id . ')" data-id="' . $data->alternative_id . '"><i class="ik ik-edit-2 f-16 mr-15 text-green"></i></a>
                                <a onclick="Delete(' . $data->alternative_id . ')" data-id="' . $data->alternative_id . '" href="#"><i class="ik ik-trash-2 f-16 text-red"></i></a>
                            </div>';
                    }else{
                        return '';
                    }
                })
                ->editColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->format('Y-m-d H:i');
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        try
        {
           
            return view('create-transaction');

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alternative_id'     => 'required',
            'criteria_id'     => 'required',
            'value'     => 'required',
          ]);
          try {
            // dd($request);
            foreach ($request->criteria_id as $key => $crtId) {
              $transaction = Transaction::create([
                'alternative_id'     => $request->alternative_id,
                'criteria_id'     => $crtId,
                'value'     => $request->weight[$key],
              ]);
            }
      
      
            return response()->json([
              'success' => true,
              'message' => 'Transaction has been added!',
              'data'    => $transaction
            ], 201);
          } catch (\Exception $e) {
            return response()->json([
              'error' => true,
              'message' => 'Transaction failed to added!',
              'data' => $e->getMessage(),
            ], 500);
          }
    }

    public function edit($id)
    {
        try {
        //   $transaction  = Transaction::with('alternatives')->find($id);
        $transaction  = Alternative::with('transactions', 'transactions.criterias')->where('id', $id)->first();

        if ($transaction) {

            return response()->json($transaction);
        } else {
            return redirect('404');
        }
        } catch (\Exception $e) {
        $bug = $e->getMessage();
        return redirect()->back()->with('error', $bug);
        }
    }

    public function update(Request $request)
    {
        try {
        $transactions = Transaction::where('alternative_id', $request->id)->get();

        foreach ($transactions as $key => $transaction) {
            $transaction->update([
            'value' => $request->weights[$key],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transactions have been updated!',
            'data'    => $transactions,
        ], 200);
        } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'message' => 'Transactions failed to update!',
            'data' => $e->getMessage(),
        ], 500);
        }
    }


    public function delete($id)
    {
        $transaction   = Transaction::find($id);
        if($transaction){
            $transaction->delete();
            return redirect('transactions')->with('success','transaksi telah terhapus!');
        }else{
            return redirect('transactions')->with('error', 'transaction not found');
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);
    
        $file = $request->file('file');
    
        try {
            $headerRow = Excel::toArray([], $file)[0][0];
            $import = new TransactionImport(array_slice($headerRow, 1)); // Exclude the first column (Name)
    
            Excel::import($import, $file);
    
            return redirect()->back()->with('success', 'Data imported successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error($e);
    
            return redirect()->back()->with('error', 'Error importing data. Check the log for details.');
        }
    }


    public function topsis()
    {
        $criterias = Criteria::all();

        //matrix awal
        $matrix = $this->Matrix();
        // Step 1: Normalize the Decision Matrix
        $normalizedMatrix = $this->normalizeDecisionMatrix();
        // Step 2: Determine Weighted Normalized Decision Matrix
        $weightedMatrix = $this->calculateWeightedMatrix($normalizedMatrix);

        // Step 3: Determine Ideal and Negative-Ideal Solutions
        $idealSolution = $this->calculateIdealSolution($weightedMatrix);
        // dd($idealSolution);
        // Step 4: Calculate Separation Measures
        $distances = $this->calculateDistances($idealSolution);
        // dd($distances);

        // Step 5: Calculate Relative Closeness to the Ideal Solution
        $resultPreference = $this->calculatePreference($distances);

        // Step 6: Rank the Alternatives
        $rankedAlternatives = $this->rankAlternatives($resultPreference);

        // Step 7: Pass the results to a view
        return view('topsis-results', 
            compact([
                'matrix',
                'normalizedMatrix',
                'weightedMatrix',
                'idealSolution',
                'distances',
                'resultPreference',
                'rankedAlternatives',
                'criterias'
            ])
        );
    }
    private function Matrix()
    {
        $alternatives = Alternative::all();
        // dd($alternatives);
        $criteriaNames = Criteria::pluck('name');
        $Matrix = [];

        foreach ($alternatives as $alternative) {
            $normalizedRow = [];
            // dd($alternative->name);
            foreach ($criteriaNames as $criteriaName) {
                $value = Transaction::where('alternative_id', $alternative->id)
                    ->whereHas('criterias', function ($query) use ($criteriaName) {
                        $query->where('name', $criteriaName);
                    })
                    ->value('value');
    
                $normalizedRow[] = $value;
            }
    
            $Matrix[$alternative->id] = [
                'id' => $alternative->id,
                'name' => $alternative->name,
                'values' => $normalizedRow,
            ];
        }
        // dd($Matrix);
        return $Matrix;

    }
    // Step 1: Normalize the Decision Matrix
    private function normalizeDecisionMatrix()
    {
        // Retrieve all alternatives
        $alternatives = Alternative::all();
        $criteriaNames = Criteria::pluck('name');
        $normalizedMatrix = [];
        $divisors = []; // Array to store divisors for each criterion

        foreach ($criteriaNames as $criteriaName) {
            // Calculate the sum of squared values for each criterion
            $sumOfSquares = Transaction::whereHas('criterias', function ($query) use ($criteriaName) {
                $query->where('name', $criteriaName);
            })->sum(DB::raw('POWER(value, 2)')); // Use DB::raw to apply POWER function in the query
        
            // Calculate the divisor as the square root of the sum of squares
            $divisor = sqrt($sumOfSquares);
            // Format the divisor with three decimal places
            // $formattedDivisor = round($divisor, 2);
            $formattedDivisor = number_format(round($divisor, 2), 2, '.', '');

            $divisors[$criteriaName] = $formattedDivisor;
        }
        
        // Calculate the sum of divisors squared
        $sumOfDivisorsSquared = array_reduce($divisors, function ($carry, $divisor) {
            return $carry + pow($divisor, 2);
        }, 0);
        
        $sumOfDivisorsSquared = sqrt($sumOfDivisorsSquared);
        
        // dd($divisors, $sumOfDivisorsSquared);
        foreach ($alternatives as $alternative) {
            $normalizedRow = [];
    
            foreach ($criteriaNames as $criteriaName) {
                $value = Transaction::where('alternative_id', $alternative->id)
                    ->whereHas('criterias', function ($query) use ($criteriaName) {
                        $query->where('name', $criteriaName);
                    })
                    ->value('value');

                // Normalize the value by dividing it with the corresponding divisor
                $normalizedValue = $divisors[$criteriaName] !== 0 ? $value / $divisors[$criteriaName] : 0;
                // $formattedValue = round($normalizedValue, 3);
                $formattedValue = number_format(round($normalizedValue,3), 3, '.', '');
    
                $normalizedRow[] = $formattedValue;
            }
    
            $normalizedMatrix[$alternative->id] = [
                'id' => $alternative->id,
                'name' => $alternative->name,
                'values' => $normalizedRow,
            ];
        }
        // dd($normalizedMatrix);
        return $normalizedMatrix;
    }
    

    // Step 2: Determine Weighted Normalized Decision Matrix
    private function calculateWeightedMatrix($normalizedMatrix)
    {
        $weightedMatrix = [];

        foreach ($normalizedMatrix as $alternativeId => $alternativeData) {
            $weightedRow = [];

            // Extract id, name, and values from alternativeData
            $id = $alternativeData['id'];
            $name = $alternativeData['name'];
            $values = $alternativeData['values'];

            $criteriaWeights = Criteria::all()->toArray();

            // Calculate the weighted values
            // dd($values);
            foreach ($values as $index => $normalizedValue) {
                // dd($criteriaWeights[$index]['weight']);
                $weightedValue = number_format($normalizedValue * $criteriaWeights[$index]['weight'], 3, '.', '');
                // $weightedRow[] = $weightedValue;
                $weightedRow[] = [
                    'criteria_id' => $criteriaWeights[$index]['id'],
                    'type' => $criteriaWeights[$index]['type'],
                    'value' => $weightedValue,
                ];
            }

            $weightedMatrix[$id] = [
                'id' => $id,
                'name' => $name,
                'values' => $weightedRow,
            ];
        }
        // dd($weightedMatrix);
        return $weightedMatrix;
    }



    private function calculateIdealSolution($weightedMatrix)
    {
        $criterias = Criteria::all();
        $values = [];
    
        foreach ($weightedMatrix as $row) {
            // dd($row['values']);
            $id = $row['id'];
            foreach ($criterias as $criteria) {
                // dd($criteria[]);

                foreach ($row['values'] as $data) {
                    # code...
                    // dd($criteria['id'] == $data['criteria_id']);
                    if ($criteria['id'] == $data['criteria_id']) {
                        
                        // dd($data['value']);
                        $weightedValue[$criteria['id']] =  [
                            'criteria_id' => $criteria['id'],
                            'name' => $criteria['name'],
                            'type' => $criteria['type'],
                            'value' => number_format($criteria['weight'] * $data['value'], 3, '.', ',')
                            // round($criteria['weight'] * $data['value'], 3)
                            // number_format($criteria['weight'] * $data['value'], 3, '.', ',')
                        ];
                        
                    }
                }
            }
            $values[$id] = [
                'id' => $id,
                'name' => $row['name'],
                'values' => $weightedValue,
            ];
        }
        // dd(json_encode($values));
        $maxValues = [];
        $minValues = [];

        foreach ($values as $item) {
            foreach ($item['values'] as $criteria) {
                $criteriaId = $criteria['criteria_id'];
                $value = floatval($criteria['value']);

                if ($criteria['type'] == 'BENEFIT') {
                    $maxValues[$criteriaId] = isset($maxValues[$criteriaId])
                        ? max($maxValues[$criteriaId], number_format($value,3 , '.', ','))
                        : number_format($value,3,'.',',');

                    $minValues[$criteriaId] = isset($minValues[$criteriaId])
                        ? min($minValues[$criteriaId], number_format($value,3 , '.', ','))
                        : number_format($value,3,'.',',');
                } elseif ($criteria['type'] == 'COST') {
                    $maxValues[$criteriaId] = isset($maxValues[$criteriaId])
                        ? min($maxValues[$criteriaId], number_format($value,3 , '.', ','))
                        : number_format($value,3,'.',',');

                    $minValues[$criteriaId] = isset($minValues[$criteriaId])
                        ? max($minValues[$criteriaId], number_format($value,3 , '.', ','))
                        : number_format($value,3,'.',',');
                }
            }
        }
        foreach ($maxValues as $maxValue) {
            $maxValue = number_format($maxValue,  3, '.', ',');
        }

        foreach ($minValues as $minValue) {
            $minValue =  number_format($minValue,  3, '.', ',');
        }

    
    
        return [
            'MAX' => $maxValues, 
            'MIN' => $minValues,
            'MatrixIdealSolutions' => $values
        ];
    }
    

    // Step 4: Calculate Separation Measures
    private function calculateDistances($idealSolution)
    {
        $MaxtrixD_Positive = [];
        $MaxtrixD_Negative = [];
        // dd($idealSolution['MAX']);
        $max = $idealSolution['MAX'];
        $min = $idealSolution['MIN'];
        $matrix = $idealSolution['MatrixIdealSolutions'];
        $newValuesMax = [];
        $newValuesMin = [];
        $DMax = [];
        $DMin = [];
        // Round the values to three decimal places
        foreach ($max as &$maxValue) {
            $maxValue = round($maxValue, 3);
        }

        foreach ($min as &$minValue) {
            $minValue = round($minValue, 3);
        }
        //matrix ideal positif
        foreach ($matrix as $item) {
            $sumValues = 0; 
            foreach ($item['values'] as $criteria) {
                $criteriaId = $criteria['criteria_id'];
                $value = floatval($criteria['value']);

                // Calculate the new value based on the provided formula
                $newValue = pow(($value - $max[$criteriaId]), 2);

                // Store the new value in the $newValuesMax array
                $newValuesMax[$criteriaId] =  [
                    'criteria_id' => $criteriaId,
                    'value' => number_format($newValue, 3, '.', ',')
                    // round($criteria['weight'] * $data['value'], 3)
                ];

                $sumValues += floatval($newValue);
            }
            $MaxtrixD_Positive[$item['id']] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'dataMatrix' => $newValuesMax,
                'dPositive' => number_format(sqrt($sumValues),3,'.',',')
            ];
            $DMax[$item['id']] = [
                'alternative_id' => $item['id'],
                'name' => $item['name'],
                'values' => number_format(sqrt($sumValues),3,'.',',')
            ];
        }

        //matrix ideal Negative
        foreach ($matrix as $item) {
            $sumValues = 0; 
            foreach ($item['values'] as $criteria) {
                $criteriaId = $criteria['criteria_id'];
                $value = floatval($criteria['value']);

                // Calculate the new value based on the provided formula
                $newValue = pow(($value - $min[$criteriaId]), 2);

                // Store the new value in the $newValuesMin array
                $newValuesMin[$criteriaId] =  [
                    'criteria_id' => $criteriaId,
                    'value' => number_format($newValue, 3, '.', ',')
                    // round($criteria['weight'] * $data['value'], 3)
                ];

                $sumValues += floatval($newValue);
            }
            $MaxtrixD_Negative[$item['id']] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'dataMatrix' => $newValuesMin,
                'dNegative' => number_format(sqrt($sumValues),3,'.',',')
            ];
            $DMin[$item['id']] = [
                'alternative_id' => $item['id'],
                'name' => $item['name'],
                'values' => number_format(sqrt($sumValues),3,'.',',')
            ];
        }
        // dd($DMax,$DMin);
        return [
            'DMax' => $DMax, 
            'DMin' => $DMin,
            'DistancePositive' => $MaxtrixD_Positive,
            'DistanceNegative' => $MaxtrixD_Negative,
        ];
        return $MaxtrixD_Positive;
    }

    // Step 5: Calculate Relative Closeness to the Ideal Solution
    private function calculatePreference($distances)
    {
        
        $alternatives = Alternative::all();
        $DPositiveValues = $distances['DMax'];
        $DNegativeValues = $distances['DMin'];
        // dd($DPositiveValues);
        $results = [];
        foreach ($alternatives as $alternative) {
            $alternativeId = $alternative->id;
            $positiveValue = $DPositiveValues[$alternativeId]['values'] ?? 0;
            // dd($DPositiveValues[$alternativeId]);
            $negativeValue = $DNegativeValues[$alternativeId]['values'] ?? 0;

            // Avoid division by zero
            $totalValue = ($positiveValue + $negativeValue) > 0 ? ($negativeValue / ($positiveValue + $negativeValue)) : 0;

            $results[] = [
                'id' => $alternativeId,
                'name' => $alternative->name,
                'DPositive_value' => $positiveValue,
                'DNegative_value' => $negativeValue,
                'result' => number_format($totalValue, 3,'.',','),
            ];
        }

        // dd($results);

        // Return the calculated closeness values
        return $results;
    }


    // Step 6: Rank the Alternatives
    private function rankAlternatives($resultPreference)
    {
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

    public function rankServerSide(Request $request)
    {
      $criterias = Criteria::all();
  
      //matrix awal
      $matrix = $this->Matrix();
      // Step 1: Normalize the Decision Matrix
      $normalizedMatrix = $this->normalizeDecisionMatrix();
      // Step 2: Determine Weighted Normalized Decision Matrix
      $weightedMatrix = $this->calculateWeightedMatrix($normalizedMatrix);
  
      // Step 3: Determine Ideal and Negative-Ideal Solutions
      $idealSolution = $this->calculateIdealSolution($weightedMatrix);
      // dd($idealSolution);
      // Step 4: Calculate Separation Measures
      $distances = $this->calculateDistances($idealSolution);
      // dd($distances);
  
      // Step 5: Calculate Relative Closeness to the Ideal Solution
      $resultPreference = $this->calculatePreference($distances);
  
      // Step 6: Rank the Alternatives
      $rankedAlternatives = $this->rankAlternatives($resultPreference);
  
  
      if ($request->ajax()) {
        
          $criterias = Criteria::all();
  
          //matrix awal
          $matrix = $this->Matrix();
          // Step 1: Normalize the Decision Matrix
          $normalizedMatrix = $this->normalizeDecisionMatrix();
          // Step 2: Determine Weighted Normalized Decision Matrix
          $weightedMatrix = $this->calculateWeightedMatrix($normalizedMatrix);
  
          // Step 3: Determine Ideal and Negative-Ideal Solutions
          $idealSolution = $this->calculateIdealSolution($weightedMatrix);
          // dd($idealSolution);
          // Step 4: Calculate Separation Measures
          $distances = $this->calculateDistances($idealSolution);
          // dd($distances);
  
          // Step 5: Calculate Relative Closeness to the Ideal Solution
          $resultPreference = $this->calculatePreference($distances);
  
          // Step 6: Rank the Alternatives
          $rankedAlternatives = $this->rankAlternatives($resultPreference);
          // array_slice($rankedAlternatives, 0, 5);
          if ($request->filterLimit) {
          $dataTable = DataTables::of(array_slice($rankedAlternatives, 0, $request->filterLimit));
          } else {
            $dataTable = DataTables::of($rankedAlternatives);

          }
  
        return $dataTable->make(true);
      }
  
  
      // dd($rankedAlternatives);
    }
}
