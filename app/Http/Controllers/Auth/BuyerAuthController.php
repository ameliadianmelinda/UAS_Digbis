<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class BuyerAuthController extends Controller
{
    public function showPortal()
    {
        return view('auth.portal');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $account = User::where('email', $credentials['email'])->first();
        if ($account && in_array($account->role, [User::ROLE_USER, User::ROLE_TENANT], true) && $account->isSuspended()) {
            return back()->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan oleh Super Admin. Silakan hubungi administrator.',
            ])->onlyInput('email');
        }

        if (Auth::attempt(array_merge($credentials, [
            'role' => User::ROLE_USER,
            'status' => User::STATUS_ACTIVE,
        ]), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['email' => 'Email atau password tidak cocok.'])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => User::ROLE_USER,
            'status' => User::STATUS_ACTIVE,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk menggunakan email dan password Anda.');
    }
}
