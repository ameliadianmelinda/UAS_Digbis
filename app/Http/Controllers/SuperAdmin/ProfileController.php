<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('superadmin.profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $user->update($request->validate(['name' => ['required', 'string', 'max:255'], 'email' => ['required', 'email', 'unique:users,email,' . $user->id]]));
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function password(Request $request)
    {
        $data = $request->validate(['current_password' => ['required'], 'password' => ['required', 'confirmed', 'min:8']]);
        if (! Hash::check($data['current_password'], $request->user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }
        $request->user()->update(['password' => $data['password']]);
        return back()->with('success', 'Password berhasil diubah.');
    }
}