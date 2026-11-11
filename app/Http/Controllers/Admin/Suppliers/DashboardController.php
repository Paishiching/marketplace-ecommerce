<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user     = $request->user();
        $supplier = $user->supplier; // suppliers table er row (na thakle null)

        return view('supplier.dashboard.index', compact('user', 'supplier'));
    }
}
