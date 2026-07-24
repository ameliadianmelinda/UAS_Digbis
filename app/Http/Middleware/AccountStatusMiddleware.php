<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccountStatusMiddleware
{
    private const SUSPENDED_MESSAGE = 'Akun Anda telah dinonaktifkan oleh Super Admin. Silakan hubungi administrator.';

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user instanceof User && $user->isSuspended() && in_array($user->role, [User::ROLE_USER, User::ROLE_TENANT], true)) {
            $loginRoute = $user->role === User::ROLE_TENANT ? 'partner.login' : 'login';

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route($loginRoute)->with('error', self::SUSPENDED_MESSAGE);
        }

        return $next($request);
    }
}
