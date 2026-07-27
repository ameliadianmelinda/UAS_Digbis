<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Review;

$reviews = Review::with('event')->get();
echo 'COUNT=' . $reviews->count() . "\n";
foreach ($reviews as $review) {
    echo sprintf(
        "id=%s event_id=%s event=%s partner_id=%s rating=%s comment=%s\n",
        $review->id,
        $review->event_id,
        $review->event?->title ?? 'NULL',
        $review->event?->partner_id ?? 'NULL',
        $review->rating,
        str_replace(["\n", "\r"], [' ', ' '], substr($review->comment ?? '', 0, 80))
    );
}
