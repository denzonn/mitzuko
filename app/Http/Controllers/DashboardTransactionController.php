<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        // Ambil transaksi detail masing-masing berdasarkan trasactions_id dari transactions
        $pendingTransactions = Transaction::where('users_id', Auth::user()->id)
            ->where('transaction_status', 'PENDING')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id');
            }])
            ->get();

        $successTransactions = Transaction::where('users_id', Auth::user()->id)
            ->where('transaction_status', 'SUCCESS')
            ->where('shipping_status', 'PENDING')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status');
            }])
            ->get();

        $shippingTransactions = Transaction::where('users_id', Auth::user()->id)
            ->where('transaction_status', 'SUCCESS')
            ->where('shipping_status', 'SHIPPING')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status');
            }])->get();

        $doneTransactions = Transaction::where('users_id', Auth::user()->id)
            ->where('transaction_status', 'SUCCESS')
            ->where('shipping_status', 'SUCCESS')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status');
            }])->get();

        $cancelTransactions = Transaction::where('users_id', Auth::user()->id)
            ->where('transaction_status', 'CANCELLED')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status');
            }])->get();

        // dd($cancelTransactions);

        return view('pages.dashboard-transactions', [
            'pendingTransactions' => $pendingTransactions,
            'successTransactions' => $successTransactions,
            'shippingTransactions' => $shippingTransactions,
            'doneTransactions' => $doneTransactions,
            'cancelTransactions' => $cancelTransactions,
        ]);
    }

    public function detail(Request $request, $id)
    {
        // $transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])
        //     ->findOrFail($id);
        // return view('pages.dashboard-transaction-details', [
        //     'transaction' => $transaction,
        // ]);

        // Ambil transaction_idnya lalu ambil data dari transaction_details
        // $transactions = Transaction::where('id', $id)
        //     ->whereHas(['transaction_details' => function ($query) {
        //         $query->with(['product.galleries'])
        //             ->selectRaw('transactions_id, products_id, count(*) as total_items')
        //             ->groupBy(
        //                 'transactions_id',
        //                 'products_id',
        //             );
        //     }])->get();
        $transactions = Transaction::whereHas('transaction_details', function ($query) {
            $query->with(['product.galleries'])
                ->selectRaw('transactions_id, products_id, count(*) as total_items')
                ->groupBy(
                    'transactions_id',
                    'products_id',
                );
        })->where('id', $id)->get();

        // dd($transactions);

        return view('pages.dashboard-transaction-details', [
            'transactions' => $transactions,
        ]);
    }

    public function success(Request $request, $id)
    {
        $item = Transaction::findOrFail($id);
        $item->shipping_status = 'SUCCESS';
        $item->save();

        $transactionDetail = TransactionDetail::where('transactions_id', $id)->get();
        foreach ($transactionDetail as $detail) {
            $detail->shipping_status = 'SUCCESS';
            $detail->save();
        }

        return redirect()->route('dashboard-transaction');
    }

    public function cancel(Request $request, $id)
    {
        $item = Transaction::findOrFail($id);

        $item->transaction_status = 'CANCELLED';
        $item->shipping_status = 'CANCELLED';

        $item->save();
        return redirect()->route('dashboard-transaction');
    }
}
