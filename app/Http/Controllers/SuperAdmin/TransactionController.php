<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('event.partner')
            ->when($request->filled('tenant_id'), fn ($query) => $query->whereHas('event', fn ($eventQuery) => $eventQuery->where('partner_id', $request->query('tenant_id'))))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->query('status')))
            ->when($request->filled('date_from'), fn ($query) => $query->whereDate('created_at', '>=', $request->query('date_from')))
            ->when($request->filled('date_to'), fn ($query) => $query->whereDate('created_at', '<=', $request->query('date_to')))
            ->latest()->paginate(20)->withQueryString();

        return view('superadmin.transactions.index', [
            'transactions' => $transactions,
            'tenants' => Partner::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function show(Transaction $transaction)
    {
        return view('superadmin.transactions.show', ['transaction' => $transaction->load('event.partner')]);
    }
}