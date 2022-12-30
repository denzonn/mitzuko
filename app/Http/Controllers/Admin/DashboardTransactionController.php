<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $transaction = TransactionDetail::with(['transaction.user', 'product.galleries']);
            // dd($category);
            return DataTables::of($transaction)
                ->make();
        }
        return view('pages.admin.dashboard-transactions');
    }
}
