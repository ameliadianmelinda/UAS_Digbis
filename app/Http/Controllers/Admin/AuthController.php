<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Fungsi menampilkan halaman view formulir
    public function showLogin() {
        return view('auth.login');
    }

    // 2. Fungsi memproses validasi Submit Log In
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(array_merge($credentials, [
            'role' => User::ROLE_SUPER_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]))) {
            if (Auth::user()?->role !== User::ROLE_SUPER_ADMIN) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun Super Admin.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->route('admin.dashboard'); // Arahkan ke rute dashboard
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda berikan tidak terdaftar di database kami.',
        ]);
    }

    // 3. Fungsi memroses Log Out (Keluar)
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

