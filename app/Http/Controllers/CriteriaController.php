<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Imports\CriteriaImport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables,Auth;
use Illuminate\Support\Facades\Validator;
class CriteriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importCriteria(Request $request)
    {
        $file = $request->file; // Assuming you have a file input named 'your_excel_file'
        // dd($file);
        Excel::import(new CriteriaImport, $file);

        return redirect()->back()->with('success', 'Criteria imported successfully!');
    }

    public function index()
    {
        return view('criteria.index');
    }

    public function getCriteriaList(Request $request)
    {
        
        // $data  = Criteria::get();
        $data = Criteria::withCount('details') // Menghitung total crips (detail) untuk setiap criteria
        ->get();

        return Datatables::of($data)
                 ->addColumn('total_crips', function ($data) {
                    return $data->details_count; // Menampilkan total crips berdasarkan count
                })
                ->addColumn('action', function($data){
                    if($data->name == 'Super Admin'){
                        return '';
                    }
                    if (Auth::user()->can('manage_criteria')){
                        return '
                            <div class="table-actions">
                                <a href="' . url('criteria/' . $data->id) . '" class="btn btn-sm btn-success text-white">
                                    <i class="ik ik-edit-2"></i> Edit
                                </a>
                                <a href="' . url('criteria-detail/' . $data->id) . '" class="btn btn-sm btn-info text-white">
                                    <i class="ik ik-archive"></i> Crips
                                </a>
                                <a href="' . url('criteria/delete/' . $data->id) . '" class="btn btn-sm btn-danger text-white" onclick="return confirm(\'Are you sure you want to delete this criteria?\')">
                                    <i class="ik ik-trash-2"></i> Delete
                                </a>
                            </div>
                        ';

                    }else{
                        return '';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        try
        {
           
            return view('create-criteria');

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
            'type'    => 'required',
            'weight' => 'required'
        ]);
        
        if($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try
        {
            // store criteria information
            $criteria = Criteria::create([
                        'name'     => $request->name,
                        'type'    => $request->type,
                        'weight'    => $request->weight,
                    ]);

            if($criteria){ 
                return redirect('criterias')->with('success', 'New Criteria created!');
            }else{
                return redirect('criterias')->with('error', 'Failed to create new criteria! Try again.');
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
            $criteria  = Criteria::find($id);

            if($criteria){

                return view('criteria.edit', compact('criteria'));
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
            'type'    => 'required',
            'weight'     => 'required'
        ]);

        
        
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }

        try{
            
            $criteria = Criteria::find($request->id);
            // dd($criteria);

            $update = $criteria->update([
                'name' => $request->name,
                'type' => $request->type,
                'weight' => $request->weight,
            ]);
            return redirect('criterias')->with('success', 'criteria information updated succesfully!');
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }


    public function delete($id)
    {
        $criteria   = Criteria::find($id);
        if($criteria){
            $criteria->delete();
            return redirect('criterias')->with('success', 'criteria removed!');
        }else{
            return redirect('criterias')->with('error', 'criteria not found');
        }
    }

}
