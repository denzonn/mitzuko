<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        $pendingTransactions = Transaction::where('transaction_status', 'PENDING')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id');
            }])
            ->get();

        $successTransactions = Transaction::where('transaction_status', 'SUCCESS')
            ->where('shipping_status', 'PENDING')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status');
            }])
            ->get();

        $shippingTransactions = Transaction::where('transaction_status', 'SUCCESS')
            ->where('shipping_status', 'SHIPPING')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status');
            }])->get();

        $doneTransactions = Transaction::where('transaction_status', 'SUCCESS')
            ->where('shipping_status', 'SUCCESS')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status');
            }])->get();

        $cancelTransactions = Transaction::where('transaction_status', 'CANCELLED')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status');
            }])->get();

        // $transactions = $pendingTransactions->concat($successTransactions)->concat($shippingTransactions)->concat($doneTransactions)->concat($cancelTransactions);
        // $userNames = $transactions->map(function ($transaction) {
        //     return $transaction->transaction->user->name;
        // });

        return view('pages.admin.dashboard-transactions', [
            'pendingTransactions' => $pendingTransactions,
            'successTransactions' => $successTransactions,
            'shippingTransactions' => $shippingTransactions,
            'doneTransactions' => $doneTransactions,
            'cancelTransactions' => $cancelTransactions,
        ]);
    }

    public function detail(Request $request, $id)
    {
        $transactions = Transaction::whereHas('transaction_details', function ($query) {
            $query->with(['product.galleries'])
                ->selectRaw('transactions_id, products_id, count(*) as total_items')
                ->groupBy(
                    'transactions_id',
                    'products_id',
                );
        })->where('id', $id)->get();

        // dd($transactions);

        return view('pages.admin.dashboard-transaction-details', [
            'transactions' => $transactions,
        ]);
    }

    public function success(Request $request, $id)
    {
        $item = Transaction::findOrFail($id);
        $item->shipping_status = 'SUCCESS';

        $item->save();

        $transactionDetail = TransactionDetail::where('transactions_id', $id)->get();

        foreach ($transactionDetail as $transactionDetail) {
            $transactionDetail->shipping_status = 'SUCCESS';
            $transactionDetail->save();
        }
        return redirect()->route('admin-dashboard-transactions');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        // Ambil transaction_details berdasarkan $id yang ada di TransactionDetails
        $transaction = Transaction::with(['transaction_details'])->find($id);

        // Save data shipping_status di Transaction
        $transaction->shipping_status = $data['shipping_status'];
        $transaction->save();

        // Save data yang diterima ke TransactionDetails
        foreach ($transaction->transaction_details as $transactionDetail) {
            $transactionDetail->shipping_status = $data['shipping_status'];
            $transactionDetail->resi = $data['resi'];
            $transactionDetail->save();
        }

        return redirect()->route('admin-dashboard-transactions');
    }
}
