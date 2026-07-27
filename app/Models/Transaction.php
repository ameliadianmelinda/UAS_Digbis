<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Review;

class Transaction extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_CHALLENGE = 'challenge';
    public const STATUS_SETTLEMENT = 'settlement';
    public const PENDING_EXPIRY_MINUTES = 2;

    protected $fillable = [
        'event_id', 'order_id', 'customer_name', 'customer_email', 'customer_phone', 'total_price', 'status', 'snap_token'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isReviewable(): bool
    {
        $isCompleted = in_array($this->status, [self::STATUS_SUCCESS, self::STATUS_SETTLEMENT], true);

        return $isCompleted && $this->event?->date?->isPast() && !$this->review;
    }

    public function isSuccess(): bool
    {
        return in_array($this->status, [self::STATUS_SUCCESS, self::STATUS_SETTLEMENT], true);
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function releaseReservation(): void
    {
        if (!$this->isPending()) {
            return;
        }

        $this->status = self::STATUS_EXPIRED;
        $this->save();
    }
}
