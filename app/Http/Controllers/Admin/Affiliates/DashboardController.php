<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user      = $request->user();
        $affiliate = $user->affiliate; // affiliates table er row (na thakle null)

        return view('affiliate.dashboard.index', compact('user', 'affiliate'));
    }
}
