<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class PolicyController extends Controller
{
    public function shipping()
    {
        return view('frontend.policies.shipping');
    }

    public function returns()
    {
        return view('frontend.policies.returns');
    }

    public function support()
    {
        return view('frontend.policies.support');
    }

    public function payment()
    {
        return view('frontend.policies.payment');
    }

    public function faq()
    {
        return view('frontend.policies.faq');
    }
}