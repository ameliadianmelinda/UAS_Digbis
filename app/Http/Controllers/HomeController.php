<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Throwable;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            // 1. Ambil semua jenis kategori untuk tampilan filter tab button
            $categories = Category::all();
            // Ambil semua partner
            $partners = \App\Models\Partner::orderBy('id', 'desc')->get();

            // 2. Buat kueri dasar untuk mengambil event:
            // - Gunakan Eager loading `category`
            // - Hanya tampilkan kegiatan dengan jadwal yang belum kedaluwarsa (>= hari ini)
            $query = Event::with('category')
                          ->where('date', '>=', now())
                          ->orderBy('date', 'asc');

            // 3. Filter query jika url memiliki parameter pencarian spesifik ?category=...
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }

            // 4. Eksekusi query dan kirim data hasilnya ke template Blade
            $events = $query->get();
        } catch (Throwable $exception) {
            $categories = collect();
            $partners = collect();
            $events = collect();
        }

        return view('welcome', compact('events', 'categories', 'partners'));
    }
}
