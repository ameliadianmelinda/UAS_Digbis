<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventPartnerController extends Controller
{
    private function buildPosterUrl(?string $posterPath): ?string
    {
        if (!$posterPath) {
            return null;
        }

        return file_exists(public_path($posterPath))
            ? asset($posterPath)
            : null;
    }

    public function index(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $partner = $user?->partner()->first();

        $query = Event::with('category')
            ->when($partner?->id, function ($query, $partnerId) {
                $query->where('partner_id', $partnerId);
            }, function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->latest('created_at');

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
                'id' => $event->id,
                'name' => $event->title,
                'subtitle' => Str::limit(strip_tags($event->description ?? ''), 48),
                'category' => $event->category?->name ?? '-',
                'date' => $event->date ? $event->date->format('d M Y') : '-',
                'location' => $event->location ?? '-',
                'sold' => $sold,
                'capacity' => $capacity,
                'status' => $status,
                'revenue' => 'Rp ' . number_format($event->transactions()->whereIn('status', ['settlement', 'success'])->sum('total_price'), 0, ',', '.'),
                'banner' => $this->buildPosterUrl($event->poster_path),
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
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $partner = $user?->partner()->first();

        if (!$partner) {
            return back()->withErrors([
                'partner' => 'Akun partner tidak ditemukan untuk user yang sedang login.',
            ])->withInput();
        }

        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'category' => 'required|string|exists:categories,name',
                'event_datetime' => 'required|date_format:Y-m-d\TH:i',
                'location' => 'required|string|max:255',
                'ticket_price' => 'required|numeric|min:0',
                'ticket_quantity' => 'required|integer|min:1',
                'description' => 'required|string',
                'poster' => 'required|image|mimes:png,jpg,jpeg,webp|max:5120',
            ],
            [
                'poster.required' => 'Poster event harus diunggah.',
                'poster.image' => 'File harus berupa gambar.',
                'poster.mimes' => 'Format gambar harus PNG, JPG, JPEG, atau WebP.',
                'poster.max' => 'Ukuran gambar tidak boleh lebih dari 5MB.',
                'name.required' => 'Nama event harus diisi.',
                'category.required' => 'Kategori harus dipilih.',
                'category.exists' => 'Kategori yang dipilih tidak valid.',
                'event_datetime.required' => 'Tanggal dan waktu event harus diisi.',
                'event_datetime.date_format' => 'Format tanggal dan waktu tidak valid.',
                'location.required' => 'Lokasi event harus diisi.',
                'ticket_price.required' => 'Harga tiket harus diisi.',
                'ticket_price.numeric' => 'Harga tiket harus berupa angka.',
                'ticket_quantity.required' => 'Jumlah tiket harus diisi.',
                'ticket_quantity.integer' => 'Jumlah tiket harus berupa angka bulat.',
                'ticket_quantity.min' => 'Jumlah tiket minimal 1.',
                'description.required' => 'Deskripsi event harus diisi.',
            ]
        );

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterFile = $request->file('poster');
            $posterName = time() . '_' . Str::slug(pathinfo($posterFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $posterFile->getClientOriginalExtension();
            $posterDirectory = public_path('uploads/events/posters');

            if (!File::exists($posterDirectory)) {
                File::makeDirectory($posterDirectory, 0755, true);
            }

            $posterFile->move($posterDirectory, $posterName);
            $posterPath = 'uploads/events/posters/' . $posterName;
        }

        $category = Category::where('name', $validated['category'])->first();

        Event::create([
            'partner_id' => $partner->id,
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

    public function update(Request $request, Event $event)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $partner = $user?->partner()->first();

        if (!$partner || $event->partner_id !== $partner->id) {
            return redirect()->route('partner.events.index')->with('error', 'Anda tidak memiliki izin untuk mengubah event ini.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|exists:categories,name',
            'event_datetime' => 'required|date_format:Y-m-d\TH:i',
            'location' => 'required|string|max:255',
            'ticket_price' => 'required|numeric|min:0',
            'ticket_quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            'poster' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5120',
        ]);

        $posterPath = $event->poster_path;
        if ($request->hasFile('poster')) {
            if ($posterPath && file_exists(public_path($posterPath))) {
                File::delete(public_path($posterPath));
            }

            $posterFile = $request->file('poster');
            $posterName = time() . '_' . Str::slug(pathinfo($posterFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $posterFile->getClientOriginalExtension();
            $posterDirectory = public_path('uploads/events/posters');

            if (!File::exists($posterDirectory)) {
                File::makeDirectory($posterDirectory, 0755, true);
            }

            $posterFile->move($posterDirectory, $posterName);
            $posterPath = 'uploads/events/posters/' . $posterName;
        }

        $category = Category::where('name', $validated['category'])->first();

        $event->update([
            'title' => $validated['name'],
            'category_id' => $category?->id,
            'description' => $validated['description'],
            'date' => $validated['event_datetime'],
            'location' => $validated['location'],
            'price' => $validated['ticket_price'],
            'stock' => $validated['ticket_quantity'],
            'poster_path' => $posterPath,
        ]);

        return redirect()->route('partner.events.index')->with('success', 'Event berhasil diperbarui!');
    }

    public function edit(Event $event)
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

        $event->poster_url = $this->buildPosterUrl($event->poster_path);

        return view('partner.eventPartner.edit', [
            'event' => $event,
            'categories' => $categories,
        ]);
    }

    public function destroy(Request $request, Event $event)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $partner = $user?->partner()->first();

        if (!$partner || $event->partner_id !== $partner->id) {
            return redirect()->route('partner.events.index')->with('error', 'Anda tidak memiliki izin untuk menghapus event ini.');
        }

        if ($request->has('_token')) {
            $request->validate([
                '_token' => 'required',
            ]);
        }

        if ($event->poster_path && file_exists(public_path($event->poster_path))) {
            File::delete(public_path($event->poster_path));
        }

        $event->delete();

        return redirect()->route('partner.events.index')->with('success', 'Event berhasil dihapus.');
    }
}
