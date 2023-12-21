<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    
    public function index()
    {
        $alternative = Alternative::all();
        $criteria = Criteria::all();
        $transactions = Transaction::all();
        // dd($alternative);
        return view('pages.dashboard', compact('alternative', 'criteria', 'transactions'));
        // return view('pages.dashboard', compact('alternatives','criterias','transactions'));
    }

    public function clearCache()
    {
        \Artisan::call('cache:clear');
        return view('clear-cache');
    }
}
