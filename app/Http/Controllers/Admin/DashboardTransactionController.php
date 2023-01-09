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
        $buyTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages.admin.dashboard-transactions', [
            'buyTransactions' => $buyTransactions,
        ]);
    }

    public function detail(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->findOrFail($id);
        return view('pages.admin.dashboard-transaction-details', [
            'transaction' => $transaction,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $item = TransactionDetail::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin-dashboard-transaction-details', $id);
    }
}
