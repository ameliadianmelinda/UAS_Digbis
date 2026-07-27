<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $partner = $user?->partner()->first();

        $partnerEvents = $partner
            ? Event::where('partner_id', $partner->id)
                ->with('transactions')
                ->latest('date')
                ->get()
            : new EloquentCollection();

        $partnerEventIds = $partnerEvents->pluck('id')->all();
        $paidStatuses = ['settlement', 'success'];

        $totalRevenue = Transaction::whereIn('event_id', $partnerEventIds)
            ->whereIn('status', $paidStatuses)
            ->sum('total_price');

        $ticketsSold = Transaction::whereIn('event_id', $partnerEventIds)
            ->whereIn('status', $paidStatuses)
            ->count();

        $activeEvents = $partnerEvents->filter(function ($event) {
            return $event->date && $event->date->greaterThanOrEqualTo(now()->startOfDay()) && ($event->status ?? 'active') !== 'inactive';
        })->count();

        $completedEvents = $partnerEvents->filter(function ($event) {
            return $event->date && $event->date->lessThan(now()->startOfDay());
        })->count();

        $stats = [
            ['label' => 'Total Event', 'value' => (string) $partnerEvents->count(), 'trend' => '+0', 'icon' => 'calendar'],
            ['label' => 'Event Aktif', 'value' => (string) $activeEvents, 'trend' => '+0', 'icon' => 'play'],
            ['label' => 'Event Selesai', 'value' => (string) $completedEvents, 'trend' => '+0', 'icon' => 'check'],
            ['label' => 'Total Tiket Terjual', 'value' => (string) $ticketsSold, 'trend' => '+0', 'icon' => 'ticket'],
            ['label' => 'Total Pendapatan', 'value' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'), 'trend' => '+0', 'icon' => 'currency'],
        ];

        $latestEvents = $partnerEvents->take(5)->map(function (Event $event) use ($paidStatuses) {
            return [
                'name' => $event->title,
                'date' => $event->date ? $event->date->translatedFormat('d F Y') : '-',
                'tickets' => $event->transactions()->whereIn('status', $paidStatuses)->count() . ' tiket',
            ];
        })->values();

        $topEvents = $partnerEvents->map(function (Event $event) use ($paidStatuses) {
            $sold = $event->transactions()->whereIn('status', $paidStatuses)->count();
            $revenue = $event->transactions()->whereIn('status', $paidStatuses)->sum('total_price');

            return [
                'name' => $event->title,
                'sales' => $sold . ' tiket',
                'income' => 'Rp ' . number_format($revenue, 0, ',', '.'),
                'revenue' => (int) $revenue,
            ];
        })->sortByDesc('revenue')->take(3)->values()->map(function (array $event) {
            unset($event['revenue']);

            return $event;
        })->values();

        $nearestEvent = $partnerEvents
            ->filter(fn ($event) => $event->date && $event->date->greaterThanOrEqualTo(now()->startOfDay()))
            ->sortBy('date')
            ->first();

        $recentTransactions = Transaction::with(['event', 'review'])
            ->whereIn('event_id', $partnerEventIds)
            ->latest('created_at')
            ->take(5)
            ->get();

        $transactions = $recentTransactions->map(function ($transaction) {
            return [
                'buyer' => $transaction->customer_name,
                'event' => $transaction->event?->title ?? '-',
                'order_id' => $transaction->order_id,
                'amount' => 'Rp ' . number_format($transaction->total_price, 0, ',', '.'),
                'status' => ucfirst($transaction->status),
            ];
        })->values();

        $partnerReviewsQuery = Review::with('event')
            ->whereHas('event', function ($query) use ($partnerEventIds) {
                $query->whereIn('id', $partnerEventIds);
            });

        $reviewCount = $partnerReviewsQuery->count();
        $averageRating = $reviewCount ? round($partnerReviewsQuery->avg('rating'), 1) : 0;

        $recentReviews = (clone $partnerReviewsQuery)
            ->latest('created_at')
            ->take(5)
            ->get();

        $activityItems = $recentReviews->map(function ($review) {
            return [
                'name' => $review->participant_name,
                'rating' => $review->rating,
                'comment' => $review->comment,
            ];
        })->values();

        $revenueByMonth = collect(range(0, 6))->map(function ($offset) use ($partnerEventIds, $paidStatuses) {
            $month = now()->subMonths(6 - $offset)->startOfMonth();

            $amount = Transaction::whereIn('event_id', $partnerEventIds)
                ->whereIn('status', $paidStatuses)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_price');

            return [
                'label' => $month->translatedFormat('M'),
                'value' => round($amount / 1000000, 1),
            ];
        });

        $ticketByMonth = collect(range(0, 6))->map(function ($offset) use ($partnerEventIds, $paidStatuses) {
            $month = now()->subMonths(6 - $offset)->startOfMonth();

            $count = Transaction::whereIn('event_id', $partnerEventIds)
                ->whereIn('status', $paidStatuses)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();

            return [
                'label' => $month->translatedFormat('M'),
                'value' => $count,
            ];
        });

        $partnerName = $partner?->name ?? $user?->name ?? 'Partner';
        $organization = $partnerName;

        return view('partner.dashboard', compact(
            'partner',
            'partnerName',
            'organization',
            'stats',
            'latestEvents',
            'topEvents',
            'nearestEvent',
            'transactions',
            'activityItems',
            'reviewCount',
            'averageRating',
            'revenueByMonth',
            'ticketByMonth'
        ));
    }

    public function preview(Request $request)
    {
        return $this->index($request);
    }
}
