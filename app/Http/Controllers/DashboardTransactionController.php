<?php

namespace App\Http\Controllers;

use App\Models\ProductComment;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\VariantType;
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
                    ->selectRaw('transactions_id, products_id, variant_type_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'variant_type_id');
            }])
            ->get();

        $successTransactions = Transaction::where('users_id', Auth::user()->id)
            ->where('transaction_status', 'SUCCESS')
            ->where('shipping_status', 'PENDING')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, variant_type_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status', 'variant_type_id');
            }])
            ->get();

        $shippingTransactions = Transaction::where('users_id', Auth::user()->id)
            ->where('transaction_status', 'SUCCESS')
            ->where('shipping_status', 'SHIPPING')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, variant_type_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status', 'variant_type_id');
            }])->get();

        $doneTransactions = Transaction::where('users_id', Auth::user()->id)
            ->where('transaction_status', 'SUCCESS')
            ->where('shipping_status', 'SUCCESS')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, variant_type_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status', 'variant_type_id');
            }])->get();

        $cancelTransactions = Transaction::where('users_id', Auth::user()->id)
            ->where('transaction_status', 'CANCELLED')
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, shipping_status, variant_type_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id', 'shipping_status', 'variant_type_id');
            }])->get();

        // dd($cancelTransactions);

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

        // dd($variantData);

        return view('pages.dashboard-transactions', [
            'variantData' => $variantData,
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

        // dd($transactions);

        return view('pages.dashboard-transaction-details', [
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

    public function review($id)
    {
        // Ambil data dari transaction_details berdasarkan id
        $transactions = TransactionDetail::where('id', $id)
            ->with(['product.galleries', 'variant_type'])
            ->get();

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

        return view('pages.dashboard-user-review', [
            'variantData' => $variantData,
            'transactions' => $transactions,
        ]);
    }

    public function addReview(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();

        // Ambil variant_type idnya dari transaction_details
        $variant_type_id = TransactionDetail::where('id', $data['transaction_details_id'])->first();

        ProductComment::create([
            'variant_type_id' => $variant_type_id->variant_type_id,
            'users_id' => $user->id,
            'products_id' => $data['products_id'],
            'comment' => $data['comment'],
            'rating' => $data['rating'],
        ]);

        // Ambil transaction_detailnya
        $transactionDetail = TransactionDetail::where('id', $data['transaction_details_id'])->first();

        // Ubah review_status menjadi true
        $transactionDetail->review_status = 1;
        $transactionDetail->save();

        return redirect()->route('dashboard-transaction-details', $transactionDetail->transactions_id);
    }
}
