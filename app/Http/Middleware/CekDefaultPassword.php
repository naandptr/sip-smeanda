<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekDefaultPassword
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->is_default_password) {
            if (!$request->is('ganti-password-awal')) {
                return redirect()->route('ganti-password-awal')->with('warning', 'Silakan ganti password default Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}
