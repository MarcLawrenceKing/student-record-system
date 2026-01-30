<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // You can pass any data you want to show on the landing page
        return view('dashboard'); // resources/views/dashboard.blade.php
    }
}
