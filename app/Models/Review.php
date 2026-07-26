<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'event_id',
        'transaction_id',
        'participant_name',
        'participant_email',
        'rating',
        'comment',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
