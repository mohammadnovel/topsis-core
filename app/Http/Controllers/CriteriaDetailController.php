<?php

namespace App\Http\Controllers;

use App\Models\CriteriaDetail;
use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Imports\CriteriaImport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables,Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class CriteriaDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index($criteriaId)
    {
        try {
            $criterias = Criteria::whereId($criteriaId)->first();
            return view('criteria.detail', compact('criterias', 'criteriaId'));
        } catch (\Exception $e) {
            Log::error('Error loading criteria details: ' . $e->getMessage());
            return back()->with('error', 'Failed to load criteria details.');
        }
    }

    public function getCriteriaList($criteriaId)
    {
        try {
            $details = CriteriaDetail::where('criteria_id', $criteriaId)->get();
            return DataTables::of($details)
                ->addColumn('criteria_name', function ($detail) {
                    return $detail->criteria->name;
                })
                ->addColumn('action', function ($detail) {
                    return '<a href="' . route('criteria-detail.edit', $detail->id) . '" class="btn btn-success btn-sm">Edit</a>
                            <form action="' . route('criteria-detail.destroy', $detail->id) . '" method="POST" style="display: inline-block;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>
                            </form>';
                })

                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Error fetching criteria details: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch criteria details.'], 500);
        }
    }

    public function store(Request $request, $criteriaId)
    {
        try {
            $request->validate([
                'criteria_id' => 'required',
                'value' => 'required',
                'description' => 'required',
            ]);

            CriteriaDetail::create($request->all());

            return redirect()->route('criteria-detail.index', $criteriaId)->with('success', 'Detail added successfully.');
        } catch (\Exception $e) {
            Log::error('Error adding criteria detail: ' . $e->getMessage());
            return redirect()->route('criteria-detail.index', $criteriaId)->with('error', 'Failed to add criteria detail.');
        }
    }

    public function edit($id)
    {
        try {
            $detail = CriteriaDetail::findOrFail($id);
            $criterias = Criteria::findOrFail($detail->criteria_id);
            return view('criteria.detail-edit', compact('detail', 'criterias'));
        } catch (\Exception $e) {
            Log::error('Error fetching criteria detail for editing: ' . $e->getMessage());
            return back()->with('error', 'Failed to fetch criteria detail for editing.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'value' => 'required',
                'description' => 'required',
            ]);

            $detail = CriteriaDetail::findOrFail($id);
            $detail->update($request->only(['value', 'description']));

            return redirect()->route('criteria-detail.index', $detail->criteria_id)
                ->with('success', 'Detail updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating criteria detail: ' . $e->getMessage());
            return redirect()->route('criteria-detail.index', $id)
                ->with('error', 'Failed to update criteria detail.');
        }
    }


    public function destroy($id)
    {
        try {
            $detail = CriteriaDetail::findOrFail($id);
            $criteriaId = $detail->criteria_id; // Save related criteria_id before deleting
            $detail->delete();

            return redirect()->route('criteria-detail.index', $criteriaId)
                ->with('success', 'Detail deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting criteria detail: ' . $e->getMessage());
            return redirect()->route('criteria-detail.index', $criteriaId ?? null)
                ->with('error', 'Failed to delete criteria detail.');
        }
    }

}
