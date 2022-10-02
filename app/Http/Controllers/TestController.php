<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $ip = $request->ip();
        $loc = Location::get('157.40.231.67');
       
        return view('test');
    }
}
