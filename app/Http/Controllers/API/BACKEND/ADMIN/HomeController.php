<?php

namespace App\Http\Controllers\API\BACKEND\ADMIN;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $title = "Dashboard";
        $active = 'dashboard';
        return view('backend.layouts.master', compact('title', 'active'));

    }
}
