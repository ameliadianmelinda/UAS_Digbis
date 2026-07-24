<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventPartnerController extends Controller
{
    private function buildPosterUrl(?string $posterPath): ?string
    {
        if (!$posterPath) {
            return null;
        }

        return Storage::disk('public')->exists($posterPath)
            ? asset('storage/' . $posterPath)
            : null;
    }

    public function index(Request $request)
    {
        $query = Event::with('category')->latest('created_at');

        $search = trim((string) $request->input('search', ''));
        $selectedCategory = trim((string) $request->input('category', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($selectedCategory !== '') {
            $query->whereHas('category', function ($categoryQuery) use ($selectedCategory) {
                $categoryQuery->where('name', $selectedCategory);
            });
        }

        $events = $query->paginate(10)->through(function ($event) {
            $sold = (int) $event->transactions()
                ->whereIn('status', ['settlement', 'success'])
                ->count();

            $capacity = max((int) $event->stock, 1);
            $progress = min(100, (int) round(($sold / $capacity) * 100));

            if ($event->date && $event->date->isPast()) {
                $status = 'Penjualan Ditutup';
            } elseif ($sold >= $capacity) {
                $status = 'Sold Out';
            } elseif ($progress >= 70) {
                $status = 'Hampir Habis';
            } else {
                $status = 'Tersedia';
            }

            return [
                'name' => $event->title,
                'subtitle' => Str::limit(strip_tags($event->description ?? ''), 48),
                'category' => $event->category?->name ?? '-',
                'date' => $event->date ? $event->date->format('d M Y') : '-',
                'location' => $event->location ?? '-',
                'sold' => $sold,
                'capacity' => $capacity,
                'status' => $status,
                'revenue' => 'Rp ' . number_format($event->transactions()->whereIn('status', ['settlement', 'success'])->sum('total_price'), 0, ',', '.'),
                'banner' => $event->poster_path ? Storage::url($event->poster_path) : null,
            ];
        });

        $categories = Category::query()
            ->select('name')
            ->get()
            ->map(function ($category) {
                return [
                    'value' => $category->name,
                    'label' => $category->name,
                ];
            })
            ->values();

        return view('partner.eventPartner.index', compact('events', 'categories', 'search', 'selectedCategory'));
    }

    public function create()
    {
        $categories = Category::query()
            ->select('name')
            ->get()
            ->map(function ($category) {
                return [
                    'value' => $category->name,
                    'label' => $category->name,
                ];
            })
            ->values();

        return view('partner.eventPartner.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|exists:categories,name',
            'event_datetime' => 'required|date_format:Y-m-d\TH:i',
            'location' => 'required|string|max:255',
            'ticket_price' => 'required|numeric|min:0',
            'ticket_quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            'poster' => 'required|image|mimes:png,jpg,jpeg,webp|max:5120',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('events/posters', 'public');
        }

        $category = Category::where('name', $validated['category'])->first();

        Event::create([
            'title' => $validated['name'],
            'category_id' => $category?->id,
            'description' => $validated['description'],
            'date' => $validated['event_datetime'],
            'location' => $validated['location'],
            'price' => $validated['ticket_price'],
            'stock' => $validated['ticket_quantity'],
            'poster_path' => $posterPath,
        ]);

        return redirect()->route('partner.events.index')->with('success', 'Event berhasil dibuat!');
    }

    public function edit(Event $event)
    {
        $categories = Category::query()
            ->select('id', 'name')
            ->get()
            ->map(function ($category) {
                return [
                    'value' => $category->id,
                    'label' => $category->name,
                ];
            })
            ->values();

        $event->poster_url = $this->buildPosterUrl($event->poster_path);

        return view('partner.eventPartner.edit', [
            'event' => $event,
            'categories' => $categories,
        ]);
    }

}
