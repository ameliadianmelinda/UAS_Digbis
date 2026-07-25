<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(Event $event)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = Category::all();

        $remainingTickets = $event->availableTicketsCount();
        $isSoldOut = $event->isSoldOut();

        return view('event-detail', compact('categories', 'event', 'remainingTickets', 'isSoldOut'));
    }

    public function availability(Event $event)
    {
        return response()->json([
            'available_tickets' => $event->availableTicketsCount(),
            'is_sold_out' => $event->isSoldOut(),
        ]);
    }

    function checkout(){
        return view('checkout');
    }

    function ticket(){
        return view('ticket');
    }
}
