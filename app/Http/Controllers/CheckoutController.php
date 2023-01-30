<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Exception;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // Save User Data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        // Process Checkout
        $code = 'MITZUKO-' . mt_rand(0000, 9999);

        // Ambil idnya lalu ubah ke array
        $ids = implode(",", $request->input('id', []));
        $id = explode(',', $ids);

        // Cek apakah ada id yang di pilih klaw tidak ada maka berikan sweetalert
        if (empty($ids)) {
            return redirect()->route('cart');
        }

        $carts = Cart::with(['product', 'user'])
            ->whereIn('id', $id)
            ->where('users_id', Auth::user()->id)
            ->get();

        //Transaction Create
        $transactions = Transaction::create([
            'users_id' => Auth::user()->id,
            'code' => $code,
            'total' => $request->total_price,
            'ongkir' => 0,
            'transaction_status' => 'PENDING',
            'shipping_status' => 'PENDING',
        ]);


        //Transaction Detail Create
        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(0000, 9999);
            $quantity = $cart->quantity;

            TransactionDetail::create([
                'users_id' => Auth::user()->id,
                'code' => $trx,
                'transactions_id' => $transactions->id,
                'products_id' => $cart->product->id,
                'price' => $cart->product->price,
                'quantity' => $quantity,
                'resi' => '',
                'shipping_status' => 'PENDING',
            ]);

            // Update Stock Product
            $cart->product->decrement('stock', $quantity);
        }

        //Delete Cart Data
        Cart::where('users_id', Auth::user()->id)
            ->whereIn('id', $id)
            ->delete();

        //Midtrans Configuration
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //Array untuk Midtrans
        $midtrans = array(
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payments' => [
                'gopay', 'bank_transfer'
            ],
            'vtweb' => []
        );

        // try {
        //     // Get Snap Payment Page URL
        //     $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

        //     // Redirect to Snap Payment Page
        //     return redirect($paymentUrl);
        // } catch (Exception $e) {
        //     echo $e->getMessage();
        // }

        $snapToken = \Midtrans\Snap::getSnapToken($midtrans);

        //Simpan snap token ke database
        $transactions->snap_token = $snapToken;
        $transactions->save();

        // Redirect ke dashboard dan kirimkan snap token
        return view('pages.checkout', [
            'snapToken' => $snapToken,
            'transactions' => $transactions,
        ]);
    }

    public function payment($id)
    {
        //Ambil data transaksi berdasarkan id transaksi kemudian ambil data dari tabel transaction_details
        $transactions = Transaction::with(['transaction_details' => function ($query) {
            $query->with(['product.galleries'])
                ->selectRaw('transactions_id, products_id, shipping_status, count(*) as total_items')
                ->groupBy('transactions_id', 'products_id', 'shipping_status');
        }])->find($id);
        $snapToken = $transactions->snap_token;

        // dd($transactions);

        return view('pages.checkout', [
            'snapToken' => $snapToken,
            'transactions' => $transactions,
        ]);
    }

    public function callback(Request $request)
    {
        // Set Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Instance midtrans notification
        $notification = new Notification();

        // Assign ke variable untuk memudahkan coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // Cari transaction berdasarkan ID
        $transaction = Transaction::findOrFail($order_id);

        // Handle notificaion status
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaction->status = 'PENDING';
                } else {
                    $transaction->status = 'SUCCESS';
                }
            }
        } else if ($status == 'settlement') {
            $transaction->status = 'SUCCESS';
        } else if ($status == 'pending') {
            $transaction->status = 'PENDING';
        } else if ($status == 'deny') {
            $transaction->status = 'CANCELLED';
        } else if ($status == 'expire') {
            $transaction->status = 'CANCELLED';
        } else if ($status == 'cancel') {
            $transaction->status = 'CANCELLED';
        }

        // Simpan transaction
        $transaction->save();

        // Kirim email ke customer
        if ($transaction) {
            if (
                $status == 'capture' && $fraud == 'accept'
            ) {
                //
            } else if (
                $status == 'settlement'
            ) {
                //
            } else if (
                $status == 'success'
            ) {
                //
            } else if ($status == 'capture' && $fraud == 'challenge') {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment Challenge'
                    ]
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment not Settlement'
                    ]
                ]);
            }

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Midtrans Notification Success'
                ]
            ]);
        }
    }
}
