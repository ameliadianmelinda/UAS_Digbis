<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Partner;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $paidStatuses = ['settlement', 'success'];
        $chartStart = now()->startOfMonth()->subMonths(11);
        $chartEnd = now()->endOfMonth();
        $monthlyLabels = [];
        $monthlyKeys = [];

        for ($month = $chartStart->copy(); $month->lte($chartEnd); $month->addMonth()) {
            $monthlyKeys[] = $month->format('Y-m');
            $monthlyLabels[] = $month->translatedFormat('M Y');
        }

        $monthlyRevenue = array_fill_keys($monthlyKeys, 0);
        $monthlyTenantRegistrations = array_fill_keys($monthlyKeys, 0);

        Transaction::whereIn('status', $paidStatuses)->whereBetween('created_at', [$chartStart, $chartEnd])
            ->get(['created_at', 'total_price'])->each(function (Transaction $transaction) use (&$monthlyRevenue) {
                $monthlyRevenue[$transaction->created_at->format('Y-m')] += (int) $transaction->total_price;
            });

        Partner::whereBetween('created_at', [$chartStart, $chartEnd])->get(['created_at'])
            ->each(function (Partner $partner) use (&$monthlyTenantRegistrations) {
                $monthlyTenantRegistrations[$partner->created_at->format('Y-m')]++;
            });

        $activities = collect()
            ->merge(Partner::latest()->take(3)->get()->map(fn (Partner $partner) => ['label' => 'Tenant baru mendaftar', 'subject' => $partner->name, 'date' => $partner->created_at]))
            ->merge(Event::latest()->take(3)->get()->map(fn (Event $event) => ['label' => 'Event baru dibuat', 'subject' => $event->title, 'date' => $event->created_at]))
            ->merge(Transaction::whereIn('status', $paidStatuses)->latest()->take(3)->get()->map(fn (Transaction $transaction) => ['label' => 'Tiket berhasil dibeli', 'subject' => $transaction->order_id, 'date' => $transaction->created_at]))
            ->sortByDesc('date')->take(8)->values();

        return view('superadmin.dashboard', [
            'totalTenants' => Partner::count(),
            'totalEvents' => Event::count(),
            'totalTicketsSold' => Transaction::whereIn('status', $paidStatuses)->count(),
            'totalPlatformRevenue' => Transaction::whereIn('status', $paidStatuses)->sum('total_price'),
            'monthlyLabels' => $monthlyLabels,
            'monthlyRevenue' => array_values($monthlyRevenue),
            'monthlyTenantRegistrations' => array_values($monthlyTenantRegistrations),
            'recentTenants' => Partner::latest()->take(5)->get(),
            'recentEvents' => Event::with(['partner', 'category'])->latest()->take(5)->get(),
            'recentTransactions' => Transaction::with('event.partner')->latest()->take(5)->get(),
            'activities' => $activities,
        ]);
    }
}