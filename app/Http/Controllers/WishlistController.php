<?php

namespace App\Http\Controllers;

use App\Models\ProductComment;
use App\Models\TransactionDetail;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::with(['product.galleries'])
            ->where('users_id', Auth::user()->id)
            ->get();

        $totalBuying = TransactionDetail::where('shipping_status', 'SUCCESS')
            ->select('products_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('products_id')
            ->get();

        // Ambil rating dari productComment 
        $rating = ProductComment::select('products_id', DB::raw('AVG(rating) as total_rating'))
            ->groupBy('products_id')
            ->get();

        return view('pages.wishlist', [
            'wishlist' => $wishlist,
            'totalBuying' => $totalBuying,
            'rating' => $rating,
        ]);
    }

    public function wishlist(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $count = Wishlist::countWishlist($data['products_id'], $data['users_id']);

            $wishlist = new Wishlist;
            if ($count == 0) {
                $wishlist->products_id = $data['products_id'];
                $wishlist->users_id = $data['users_id'];
                $wishlist->save();
                return response()->json([
                    'action' => 'add',
                    'message' => 'Product berhasil ditambahkan ke wishlist',
                ]);
            } else {
                Wishlist::where('products_id', $data['products_id'])->where('users_id', $data['users_id'])->delete();
                return response()->json([
                    'action' => 'remove',
                    'message' => 'Product berhasil dihapus dari wishlist',
                ]);
            }
        }
    }
}
