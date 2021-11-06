<?php

namespace App\Http\Controllers\API\FRONTEND\DFLT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        // return "OK";
        $title = "Dashboard";
        $active = 'dashboard';
        return view('frontend.layouts.master', compact('title', 'active'));
        // return view('frontend.welcome', compact('title', 'active'));
    }
}
