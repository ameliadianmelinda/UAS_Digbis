<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->query('search');
                $query->where(fn ($userQuery) => $userQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"));
            })->latest()->paginate(10)->withQueryString();

        return view('superadmin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('partner');

        return view('superadmin.users.show', compact('user'));
    }

    public function suspend(User $user)
    {
        abort_unless($user->role === User::ROLE_USER, 404);
        $user->update(['status' => User::STATUS_SUSPENDED]);

        return back()->with('success', 'User berhasil disuspend.');
    }

    public function activate(User $user)
    {
        abort_unless($user->role === User::ROLE_USER, 404);
        $user->update(['status' => User::STATUS_ACTIVE]);

        return back()->with('success', 'User berhasil diaktifkan.');
    }
}