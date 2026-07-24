<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TicketHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $transactions = Transaction::with('event')
            ->where('customer_email', $user->email)
            ->latest()
            ->paginate(10);

        return view('tickets.history', compact('user', 'transactions'));
    }

    public function show(Request $request, Transaction $transaction)
    {
        abort_unless($transaction->customer_email === $request->user()->email, 403);

        return view('tickets.show', [
            'user' => $request->user(),
            'transaction' => $transaction->load('event'),
        ]);
    }
}