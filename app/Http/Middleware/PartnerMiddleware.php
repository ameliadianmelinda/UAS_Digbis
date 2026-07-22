<?php

namespace App\Http\Middleware;

use Closure;
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

        if (Auth::user()?->role !== 'partner') {
            abort(403, 'Anda tidak punya akses ke halaman partner.');
        }

        return $next($request);
    }
}