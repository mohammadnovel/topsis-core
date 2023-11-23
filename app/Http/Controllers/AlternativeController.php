<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AlternativesImport;
use Illuminate\Http\Request;
use App\Models\Alternative;

class AlternativeController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $file = $request->file('file');

        try {
            Excel::import(new AlternativesImport, $file);

            return redirect()->route('alternatives.index')->with('success', 'Alternatives imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('alternatives.index')->with('error', 'Error importing alternatives. ' . $e->getMessage());
        }
    }
}
