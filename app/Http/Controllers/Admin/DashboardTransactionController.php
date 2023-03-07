<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\VariantType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        $pendingTransactions = Transaction::where('transaction_status', 'PENDING')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, variant_type_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'variant_type_id');
            }])
            ->get();

        $successTransactions = Transaction::where('transaction_status', 'SUCCESS')
            ->where('shipping_status', 'PENDING')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, variant_type_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status', 'variant_type_id');
            }])
            ->get();

        $shippingTransactions = Transaction::where('transaction_status', 'SUCCESS')
            ->where('shipping_status', 'SHIPPING')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, variant_type_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status', 'variant_type_id');
            }])->get();

        $doneTransactions = Transaction::where('transaction_status', 'SUCCESS')
            ->where('shipping_status', 'SUCCESS')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, variant_type_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status', 'variant_type_id');
            }])->get();

        $cancelTransactions = Transaction::where('transaction_status', 'CANCELLED')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, variant_type_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status', 'variant_type_id');
            }])->get();

        $codTransactions = Transaction::where('transaction_status', 'SUCCESS')
            ->where('payment_method', 'cod')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, variant_type_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status', 'variant_type_id');
            }])->get();

        // $transactions = $pendingTransactions->concat($successTransactions)->concat($shippingTransactions)->concat($doneTransactions)->concat($cancelTransactions);
        // $userNames = $transactions->map(function ($transaction) {
        //     return $transaction->transaction->user->name;
        // });

        // Ambil variant_type_id dari transaction_details
        $variant = TransactionDetail::where('variant_type_id', '!=', null)
            ->with(['variant_type'])
            ->get();

        // Lakukan perulangan $variant
        $variant_type_id = [];
        foreach ($variant as $item) {
            // Ambil variant_type_id dari transaction_details
            $variant_type_id[] = $item->variant_type_id;
        }
        // Ambil data dari variant_type berdasarkan variant_type_id
        $variantData = VariantType::whereIn('id', $variant_type_id)->get();

        return view('pages.admin.dashboard-transactions', [
            'variantData' => $variantData,
            'codTransactions' => $codTransactions,
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
                ->selectRaw('transactions_id, products_id, variant_type_id, count(*) as total_items')
                ->groupBy(
                    'variant_type_id',
                    'transactions_id',
                    'products_id',
                );
        })->where('id', $id)->get();

        // dd($transactions);

        // Ambil variant_type_id dari transaction_details
        $variant = TransactionDetail::where('variant_type_id', '!=', null)
            ->with(['variant_type'])
            ->get();

        // Lakukan perulangan $variant
        $variant_type_id = [];
        foreach ($variant as $item) {
            // Ambil variant_type_id dari transaction_details
            $variant_type_id[] = $item->variant_type_id;
        }
        // Ambil data dari variant_type berdasarkan variant_type_id
        $variantData = VariantType::whereIn('id', $variant_type_id)->get();

        return view('pages.admin.dashboard-transaction-details', [
            'variantData' => $variantData,
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
