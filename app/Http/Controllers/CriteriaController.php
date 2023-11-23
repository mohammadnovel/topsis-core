<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Imports\CriteriaImport;
use Maatwebsite\Excel\Facades\Excel;

class CriteriaController extends Controller
{
    public function importCriteria(Request $request)
    {
        $file = $request->file('your_excel_file'); // Assuming you have a file input named 'your_excel_file'

        Excel::import(new CriteriaImport, $file);

        return redirect()->back()->with('success', 'Criteria imported successfully!');
    }
}
