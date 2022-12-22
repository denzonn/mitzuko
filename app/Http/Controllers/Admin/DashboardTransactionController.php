<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard-transactions');
    }
}
