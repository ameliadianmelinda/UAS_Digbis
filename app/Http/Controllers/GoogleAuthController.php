<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(Request $request)
    {
        session()->put('url.intended', route('home'));

        return Socialite::driver('google')->redirect();
    }

    public function redirectForCheckout(Event $event)
    {
        session()->put('url.intended', route('checkout.create', $event));

        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $exception) {
            return redirect()->intended(route('home'))->with('error', 'Login Google gagal diproses. Silakan coba lagi.');
        }

        $user = User::firstOrNew([
            'email' => $googleUser->getEmail(),
        ]);

        if ($user->exists && $user->role !== 'user') {
            return redirect()->route('login')->with('error', 'Email ini terdaftar sebagai admin atau partner. Gunakan login yang sesuai.');
        }

        $user->name = $googleUser->getName() ?: $googleUser->getNickname() ?: 'Google User';
        $user->google_id = $googleUser->getId();
        $user->avatar = $googleUser->getAvatar();
        $user->email_verified_at = $user->email_verified_at ?? now();

        if (! $user->exists) {
            $user->password = bcrypt(Str::random(32));
            $user->role = 'user';
        }

        $user->save();

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }
}