<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Transaction $transaction)
    {
        $user = Auth::user();

        abort_unless($user !== null, 403);
        abort_unless($transaction->customer_email === $user->email, 403);
        abort_unless($transaction->status === Transaction::STATUS_SUCCESS, 403);
        abort_unless($transaction->event?->date?->isPast(), 403);
        abort_unless(!$transaction->review, 409);

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'event_id' => $transaction->event_id,
            'transaction_id' => $transaction->id,
            'participant_name' => $transaction->customer_name,
            'participant_email' => $transaction->customer_email,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? '',
        ]);

        return back()->with('success', 'Terima kasih! Review Anda telah dikirim.');
    }
}
