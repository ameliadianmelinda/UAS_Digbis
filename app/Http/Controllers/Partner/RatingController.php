<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class RatingController extends Controller
{
    public function index()
    {
        $reviews = collect([
            [
                'participant' => 'Raka Pratama',
                'event' => 'Tech Conference 2026',
                'rating' => 5,
                'review' => 'Event sangat bagus, materi jelas, dan panitianya sangat responsif. Saya puas mengikuti acara ini.',
                'date' => '24 Jul 2026',
            ],
            [
                'participant' => 'Dina Lestari',
                'event' => 'Workshop UI/UX',
                'rating' => 4,
                'review' => 'Acara bagus, tapi sesi Q&A sedikit kurang lama. Secara keseluruhan tetap recommended.',
                'date' => '23 Jul 2026',
            ],
            [
                'participant' => 'Fahri Zulkarnaen',
                'event' => 'Startup Summit',
                'rating' => 5,
                'review' => 'Tempat keren, speaker hebat, serta networking session sangat bermanfaat untuk pengembangan bisnis.',
                'date' => '22 Jul 2026',
            ],
            [
                'participant' => 'Sinta Putri',
                'event' => 'Laravel Bootcamp',
                'rating' => 3,
                'review' => 'Materi cukup oke, tetapi waktunya terasa padat dan ada beberapa sesi yang perlu lebih detail.',
                'date' => '21 Jul 2026',
            ],
            [
                'participant' => 'Budi Santoso',
                'event' => 'Design Sprint Masterclass',
                'rating' => 4,
                'review' => 'Proses mentor dan praktiknya terasa nyata, saya mendapatkan banyak insight baru untuk proyek saya.',
                'date' => '20 Jul 2026',
            ],
            [
                'participant' => 'Maya Ardianti',
                'event' => 'Product Launch Festival',
                'rating' => 2,
                'review' => 'Secara umum lumayan, tapi beberapa bagian teknis masih terasa kurang siap dan belum terorganisir.',
                'date' => '19 Jul 2026',
            ],
        ]);

        return view('partner.rating', compact('reviews'));
    }
}
