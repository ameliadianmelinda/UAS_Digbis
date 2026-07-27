<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Partner;
use App\Models\Event;
use App\Models\Review;
use App\Models\User;

echo "PARTNERS\n";
foreach (Partner::all() as $partner) {
    echo sprintf("id=%s name=%s email=%s user_id=%s\n", $partner->id, $partner->name, $partner->email, $partner->user_id);
}

echo "\nEVENTS\n";
foreach (Event::all() as $event) {
    echo sprintf("id=%s title=%s partner_id=%s\n", $event->id, $event->title, $event->partner_id);
}

echo "\nREVIEWS\n";
foreach (Review::with('event')->get() as $review) {
    echo sprintf("id=%s event_id=%s event=%s partner_id=%s rating=%s\n", $review->id, $review->event_id, $review->event?->title ?? 'NULL', $review->event?->partner_id ?? 'NULL', $review->rating);
}

echo "\nPARTNER USERS\n";
foreach (User::where('role', 'tenant')->get() as $user) {
    echo sprintf("id=%s name=%s email=%s partner_id=%s\n", $user->id, $user->name, $user->email, $user->partner?->id ?? 'NULL');
}
