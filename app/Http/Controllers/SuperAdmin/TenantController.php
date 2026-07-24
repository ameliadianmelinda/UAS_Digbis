<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $tenants = Partner::query()
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->query('search') . '%'))
            ->latest()->paginate(10)->withQueryString();

        return view('superadmin.tenants.index', compact('tenants'));
    }

    public function show(Partner $partner)
    {
        $partner->load('events.category');
        $eventIds = $partner->events->pluck('id');
        $paid = Transaction::whereIn('event_id', $eventIds)->whereIn('status', ['settlement', 'success']);

        return view('superadmin.tenants.show', [
            'tenant' => $partner,
            'totalTicketsSold' => (clone $paid)->count(),
            'totalRevenue' => (clone $paid)->sum('total_price'),
        ]);
    }

    public function suspend(Partner $partner)
    {
        $partner->update(['status' => 'suspended']);
        return back()->with('success', 'Tenant berhasil disuspend.');
    }

    public function activate(Partner $partner)
    {
        $partner->update(['status' => 'active']);
        return back()->with('success', 'Tenant berhasil diaktifkan.');
    }
}