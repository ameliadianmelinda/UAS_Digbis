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
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%"));
            })->latest()->paginate(10)->withQueryString();

        return view('superadmin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('superadmin.users.show', compact('user'));
    }
}