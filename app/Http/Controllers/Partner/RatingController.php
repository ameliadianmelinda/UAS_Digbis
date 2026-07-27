<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));
        $rating = trim($request->query('rating', ''));
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $partner = $user?->partner()->first();

        $partnerEventIds = $partner
            ? Event::where('partner_id', $partner->id)->pluck('id')->all()
            : [];

        $reviewsQuery = Review::with('event')
            ->whereIn('event_id', $partnerEventIds);

        if ($search !== '') {
            $reviewsQuery->where(function ($query) use ($search) {
                $query->where('participant_name', 'like', "%{$search}%")
                    ->orWhere('comment', 'like', "%{$search}%")
                    ->orWhereHas('event', function ($query) use ($search) {
                        $query->where('title', 'like', "%{$search}%");
                    });
            });
        }

        if ($rating !== '' && in_array($rating, ['1', '2', '3', '4', '5'], true)) {
            $reviewsQuery->where('rating', $rating);
        }

        $reviews = $reviewsQuery
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($review) {
                return [
                    'participant' => $review->participant_name,
                    'event' => $review->event?->title ?? '-',
                    'rating' => $review->rating,
                    'review' => $review->comment ?? '',
                    'date' => optional($review->created_at)->translatedFormat('d M Y') ?: '-',
                ];
            });

        return view('partner.rating', compact('reviews', 'search', 'rating'));
    }
}
