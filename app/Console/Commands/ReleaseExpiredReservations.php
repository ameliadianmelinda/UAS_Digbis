<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReleaseExpiredReservations extends Command
{
    protected $signature = 'tickets:release-expired {--minutes=}';
    protected $description = 'Release expired reserved tickets by marking pending transactions as expired.';

    public function handle(): int
    {
        $minutes = $this->option('minutes') ?: \App\Models\Transaction::PENDING_EXPIRY_MINUTES;
        $expireTime = Carbon::now()->subMinutes((int) $minutes);

        $expiredTransactions = Transaction::with('event')
            ->where('status', Transaction::STATUS_PENDING)
            ->where('created_at', '<=', $expireTime)
            ->get();

        $released = 0;

        foreach ($expiredTransactions as $transaction) {
            if ($transaction->isPending()) {
                $transaction->releaseReservation();
                $released++;
            }
        }

        $this->info("Released {$released} expired reservation(s).");

        return 0;
    }
}
