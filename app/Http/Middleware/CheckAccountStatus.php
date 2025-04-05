<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
{
    // app/Http/Middleware/CheckAccountStatus.php
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Skip untuk admin utama
            if ($user->role === User::ROLE_ADMIN_UTAMA) {
                return $next($request);
            }

            if ($user->status === User::STATUS_PENDING) {
                return redirect()->route('setup-akun');
            }

            if ($user->status !== User::STATUS_AKTIF) {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'username' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                ]);
            }
        }
        return $next($request);
    }
}