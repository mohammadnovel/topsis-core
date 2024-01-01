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

}
