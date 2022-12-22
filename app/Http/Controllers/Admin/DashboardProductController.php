<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardProductController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard-products');
    }
    public function detail()
    {
        return view('pages.admin.dashboard-products-details');
    }
    public function create()
    {
        return view('pages.admin.dashboard-products-create');
    }
}
