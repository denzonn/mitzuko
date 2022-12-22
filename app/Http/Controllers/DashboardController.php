<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard');
    }
    public function transaction()
    {
        return view('pages.dashboard-transactions');
    }
}
