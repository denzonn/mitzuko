<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class updateTransactionStatusEveryDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateTransactionStatusEveryDay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transaction Status will be updated to CANCELLED if it is PENDING and created more than 1 day ago';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pendingTransactions = Transaction::where('transaction_status', 'PENDING')
            ->where('created_at', '<', Carbon::now()->subDay())
            ->with(['transaction_details' => function ($query) {
                $query->with(['product.galleries'])
                    ->selectRaw('transactions_id, products_id, count(*) as total_items')
                    ->groupBy('transactions_id', 'products_id');
            }])
            ->get();
        foreach ($pendingTransactions as $transaction) {
            $transaction->transaction_status = 'CANCELLED';
            $transaction->save();
        }
    }
}
