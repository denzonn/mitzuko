<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{
    public function getMonthPurchases()
    {
        $purchases = DB::table('transactions')
            ->select(DB::raw('created_at as hari, COUNT(*) as total_quantity'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('created_at', 'asc')
            ->take(10)
            ->get();

        foreach ($purchases as $purchase) {
            $purchase->hari = Carbon::parse($purchase->hari)->format('j F Y');
        }

        $response = [
            'status' => 200,
            'data' => $purchases
        ];

        return response()->json($response);
    }

    public function topProduct()
    {
        $topProduct = DB::table('transaction_details')
            ->select('products.name', DB::raw('SUM(transaction_details.quantity) as total_quantity'))
            ->join('products', 'products.id', '=', 'transaction_details.products_id')
            ->groupBy('products.name')
            ->orderBy('total_quantity', 'desc')
            ->take(5)
            ->get();

        $response = [
            'status' => 200,
            'data' => $topProduct
        ];

        return response()->json($response);
    }
}
