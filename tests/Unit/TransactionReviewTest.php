<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionReviewTest extends TestCase
{
    public function test_settlement_transactions_can_be_reviewed_after_event_is_past(): void
    {
        $transaction = new Transaction(['status' => 'settlement']);
        $transaction->setRelation('event', new Event(['date' => now()->subDay()]));
        $transaction->setRelation('review', null);

        $this->assertTrue($transaction->isReviewable());
    }
}
