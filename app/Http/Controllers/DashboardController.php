<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $transactions = TransactionDetail::with(['transaction.user', 'product.galleries']);
        return view('pages.dashboard', [
            'transaction_data' => $transactions->get(),
        ]);
    }

    public function detail()
    {
        return view('pages.dashboard-transaction-details');
    }
}
