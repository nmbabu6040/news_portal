<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            auth()->logout();
            return redirect()->route('admin.login')->with('error', 'অ্যাডমিন অ্যাকাউন্ট দিয়ে লগইন করুন।');
        }

        return $next($request);
    }
}
