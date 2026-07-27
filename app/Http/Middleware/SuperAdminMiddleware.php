<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('superadmin.login');
        }

        if (Auth::user()?->role !== User::ROLE_SUPER_ADMIN) {
            abort(403, 'Anda tidak punya akses ke halaman Super Admin.');
        }

        return $next($request);
    }
}