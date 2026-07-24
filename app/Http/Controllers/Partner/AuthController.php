<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('partner.login');
    }

    public function showRegister()
    {
        return view('partner.register');
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
            ]);
        }

        if (Auth::attempt(array_merge($credentials, [
            'role' => User::ROLE_TENANT,
            'status' => User::STATUS_ACTIVE,
        ]))) {
            if (Auth::user()?->role !== User::ROLE_TENANT) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Akun ini bukan akun Tenant.',
                ]);
            }

            $request->session()->regenerate();

            return redirect()->route('partner.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda berikan tidak terdaftar di database kami.',
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama_organisasi' => ['required', 'string', 'max:255'],
            'nama_pic' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nama_organisasi.required' => 'Nama Organisasi wajib diisi.',
            'nama_organisasi.max' => 'Nama Organisasi tidak boleh lebih dari 255 karakter.',
            'nama_pic.required' => 'Nama PIC wajib diisi.',
            'nama_pic.max' => 'Nama PIC tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus format yang valid.',
            'email.unique' => 'Email sudah terdaftar di sistem kami.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.max' => 'Nomor HP tidak boleh lebih dari 20 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        // Create User with TENANT role
        $user = User::create([
            'name' => $data['nama_pic'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => User::ROLE_TENANT,
            'status' => User::STATUS_ACTIVE,
        ]);

        // Create Partner record
        Partner::create([
            'user_id' => $user->id,
            'name' => $data['nama_organisasi'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'logo_url' => 'https://placehold.co/200x200',
            'status' => User::STATUS_ACTIVE,
        ]);

        return redirect()->route('partner.login')->with('success', 'Registrasi berhasil. Silakan login sebagai Event Partner.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}