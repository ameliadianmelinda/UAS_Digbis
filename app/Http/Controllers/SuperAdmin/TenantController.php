<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $tenants = Partner::query()
            ->whereHas('user', fn ($query) => $query->where('role', User::ROLE_TENANT))
            ->with(['user', 'events'])
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->query('search') . '%'))
            ->latest()->paginate(10)->withQueryString();

        return view('superadmin.tenants.index', compact('tenants'));
    }

    public function show(Partner $partner)
    {
        $partner->load('user', 'events.category');
        abort_unless($partner->user?->role === User::ROLE_TENANT, 404);
        $eventIds = $partner->events->pluck('id');
        $paid = Transaction::whereIn('event_id', $eventIds)->whereIn('status', ['settlement', 'success']);

        return view('superadmin.tenants.show', [
            'tenant' => $partner,
            'status' => $partner->user->status,
            'phone' => $partner->phone,
            'address' => $partner->address,
            'totalTicketsSold' => (clone $paid)->count(),
            'totalRevenue' => (clone $paid)->sum('total_price'),
        ]);
    }

    public function suspend(Partner $partner)
    {
        $partner->load('user');
        abort_unless($partner->user?->role === User::ROLE_TENANT, 404);
        $partner->update(['status' => User::STATUS_SUSPENDED]);
        $partner->user->update(['status' => User::STATUS_SUSPENDED]);
        return back()->with('success', 'Tenant berhasil disuspend.');
    }

    public function activate(Partner $partner)
    {
        $partner->load('user');
        abort_unless($partner->user?->role === User::ROLE_TENANT, 404);
        $partner->update(['status' => User::STATUS_ACTIVE]);
        $partner->user->update(['status' => User::STATUS_ACTIVE]);
        return back()->with('success', 'Tenant berhasil diaktifkan.');
    }
}