<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with(['partner', 'category'])
            ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', '%' . $request->query('search') . '%'))
            ->latest()->paginate(10)->withQueryString();

        return view('superadmin.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load(['partner', 'category']);
        $paid = $event->transactions()->whereIn('status', ['settlement', 'success']);

        return view('superadmin.events.show', [
            'event' => $event,
            'ticketsSold' => (clone $paid)->count(),
            'revenue' => (clone $paid)->sum('total_price'),
        ]);
    }

    public function disable(Event $event)
    {
        $event->update(['status' => 'inactive']);
        return back()->with('success', 'Event berhasil dinonaktifkan.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('superadmin.events.index')->with('success', 'Event berhasil dihapus.');
    }
}