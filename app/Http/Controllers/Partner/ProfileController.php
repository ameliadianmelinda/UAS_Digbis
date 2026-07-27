<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $partner = $user?->partner()->first();

        $eventIds = $partner ? $partner->events()->pluck('id')->all() : [];
        $reviewStats = [
            'average' => 0.0,
            'count' => 0,
        ];

        if (!empty($eventIds)) {
            $reviewStats['average'] = round((float) \App\Models\Review::whereIn('event_id', $eventIds)->avg('rating'), 1);
            $reviewStats['count'] = \App\Models\Review::whereIn('event_id', $eventIds)->count();
        }

        $profile = [
            'logo' => $partner?->logo_url,
            'org_name' => $partner?->name ?? $user?->name ?? '-',
            'pic_name' => $user?->name ?? '-',
            'org_email' => $partner?->email ?? $user?->email ?? '-',
            'phone' => $partner?->phone ?? '-',
            'address' => $partner?->address ?? '-',
            'status' => $partner?->status ?? 'Aktif',
            'rating' => $reviewStats['average'],
            'review_count' => $reviewStats['count'],
        ];

        return view('partner.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $partner = $user?->partner()->first();

        $rules = [
            'password' => ['nullable', 'string', 'confirmed', 'min:8'],
            'current_password' => ['required_with:password', 'current_password'],
        ];

        $messages = [
            'current_password.current_password' => 'Password lama salah.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal :min karakter.',
        ];

        $data = $request->validate($rules, $messages);

        // Handle password change (validation already checked current_password)
        if ($request->filled('password')) {
            $user->password = $request->input('password');
            $user->save();
        }

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
