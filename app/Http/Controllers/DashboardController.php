<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Dd;

class DashboardController extends Controller
{
    public function index()
    {
        $buyTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->whereHas('transaction', function ($transaction) {
                // dd($transaction);
                $transaction->where('users_id', Auth::user()->id);
                // ->where('created_at', '>=', now()->subWeek());
            })->get();
        dd($buyTransactions);

        return view('pages.dashboard', [
            'buyTransactions' => $buyTransactions,
        ]);
    }

    public function detail()
    {
        return view('pages.dashboard-transaction-details');
    }
}
