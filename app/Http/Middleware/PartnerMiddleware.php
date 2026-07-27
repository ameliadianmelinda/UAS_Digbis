<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PartnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect('/partner/login');
        }

        if (Auth::user()?->role !== User::ROLE_TENANT) {
            abort(403, 'Anda tidak punya akses ke halaman Tenant.');
        }

        $user = Auth::user();
        if ($user instanceof User && $user->isSuspended()) {
            Auth::logout();
            return redirect('/partner/login')->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan oleh Super Admin. Silakan hubungi administrator.',
            ]);
        }

        return $next($request);
    }
}