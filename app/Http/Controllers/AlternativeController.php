<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AlternativesImport;
use Illuminate\Http\Request;
use App\Models\Alternative;
use DataTables,Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
class AlternativeController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $file = $request->file;

        try {
            Excel::import(new AlternativesImport, $file);

            return redirect()->back()->with('success', 'Alternative imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing alternatives. ' . $e->getMessage());
        }
    }

    public function index()
    {
        return view('alternative.index');
    }

    public function getAlternativeList(Request $request)
    {
        
        $data  = Alternative::get();

        return Datatables::of($data)
                
                ->addColumn('action', function($data){
                    if($data->name == 'Super Admin'){
                        return '';
                    }
                    if (Auth::user()->can('manage_alternative')){
                        return '<div class="table-actions">
                                <a href="'.url('alternative/'.$data->id).'" ><i class="ik ik-edit-2 f-16 mr-15 text-green"></i></a>
                                <a href="'.url('alternative/delete/'.$data->id).'"><i class="ik ik-trash-2 f-16 text-red"></i></a>
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
           
            return view('create-alternative');

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    public function store(Request $request)
    {
        // create user 
        $validator = Validator::make($request->all(), [
            'name'     => 'required | string ',
        ]);
        
        if($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {
            // store alternative information
            $alternative = Alternative::create([
                        'name'     => $request->name,
                    ]);

            if($alternative){ 
                return redirect('alternatives')->with('success', $alternative->name.' telah berhasil di tambah!');
            }else{
                return redirect('alternatives')->with('error', 'Failed to create new alternative! Try again.');
            }
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit($id)
    {
        try
        {
            $alternative  = Alternative::find($id);

            if($alternative){

                return view('alternative.edit', compact('alternative'));
            }else{
                return redirect('404');
            }

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function update(Request $request)
    {

        // update user info
        $validator = Validator::make($request->all(), [
            'id'       => 'required',
            'name'     => 'required | string ',
        ]);

        
        
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }

        try{
            
            $alternative = Alternative::find($request->id);
            // dd($alternative);

            $update = $alternative->update([
                'name' => $request->name,
            ]);
            return redirect('alternatives')->with('success', 'alternative information updated succesfully!');
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }


    public function delete($id)
    {
        $alternative   = Alternative::find($id);
        if($alternative){
            $alternative->delete();
            return redirect('alternatives')->with('success', $alternative->name.' telah terhapus!');
        }else{
            return redirect('alternatives')->with('error', 'alternative not found');
        }
    }
}
