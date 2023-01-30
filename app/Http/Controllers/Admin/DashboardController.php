<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $costumer = User::count();
        $profit = Transaction::where('transaction_status', 'SUCCESS')
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('shipping_status', 'SUCCESS')
            ->sum('total');
        $marginProfit = round(($profit * 0.05), 0);
        $transaction = Transaction::count();

        return view('pages.admin.dashboard', [
            'costumer' => $costumer,
            'marginProfit' => $marginProfit,
            'profit' => $profit,
            'transaction' => $transaction
        ]);
    }
}
