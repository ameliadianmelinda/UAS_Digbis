<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $user = $request->user();
        $transactions = Transaction::with('event')
            ->where('customer_email', $user->email)
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact('user', 'transactions'));
    }
}