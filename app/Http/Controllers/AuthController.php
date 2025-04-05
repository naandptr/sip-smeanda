<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; 
use App\Mail\AccountConfirmationMail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Debugging
        Log::info('Login attempt for: '.$credentials['username']);
        

        $user = User::where('username', $credentials['username'])->first();

        // if (!$user) {
        //     Log::warning('User not found: '.$credentials['username']);
        //     return back()->withErrors(['username' => 'Username tidak terdaftar']);
        // }
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            Log::info('Auth attempt successful, user: '.Auth::user()->username);
            return redirect()->intended(route('dashboard'));
        } else {
            Log::warning('Auth attempt failed for: '.$credentials['username']);
            return back()->withErrors(['username' => 'Login gagal']);
        }
        

        if (!Hash::check($credentials['password'], $user->password)) {
            Log::warning('Password mismatch for: '.$user->username);
            return back()->withErrors(['password' => 'Password salah']);
        }
        
        Log::info('Password match for user: '.$user->username);
        

        // Skip email verification for admin
        if ($user->role !== User::ROLE_ADMIN_UTAMA && !$user->hasVerifiedEmail()) {
            return back()->withErrors(['email' => 'Email belum diverifikasi']);
        }

        Auth::login($user);

    
        // if ($user->status === User::STATUS_PENDING) {
        //     Log::info('Redirecting to setup account for user: '.$user->username);
        //     return redirect()->route('setup-akun');
        // }

        if ($user->status === User::STATUS_PENDING) {
            Log::info('Redirecting user to setup account: '.$user->username);
            Log::info('User status saat login: ' . json_encode($user->status));
            return redirect()->route('setup-akun');
        } else {
            Log::info('User status is not pending: '.$user->username);
        }
        

        if ($user->status !== User::STATUS_AKTIF) {
            Log::warning('User  account is inactive: '.$user->username);
            return back()->withErrors(['username' => 'Akun dinonaktifkan']);
        }

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showSetupForm()
    {
        // if (!Auth::check() || Auth::user()->status !== User::STATUS_PENDING) {
        //     return redirect()->route('login');
        // }

        // return view('auth.setup_akun');

        if (!Auth::check()) {
            Log::warning('User  is not authenticated, redirecting to login.');
            return redirect()->route('login');
        }
    
        $user = Auth::user();
        Log::info('User  accessing setup form: '.$user->username.' with status: '.$user->status);
    
        if ($user->status !== User::STATUS_PENDING) {
            Log::warning('User status is not pending, redirecting to login.');
            return redirect()->route('login');
        }
    
        return view('auth.setup_akun');

    }

    public function setupAccount(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || $user->status !== User::STATUS_PENDING) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'emailUser' => 'required|email|unique:tbl_users,email',
            'newPw' => 'required|string|min:6',
            'confirmPw' => 'required|same:newPw',
        ]);

        // Gunakan fill + save sebagai alternatif
        $user->email = $validated['emailUser'];
        $user->password = Hash::make($validated['newPw']);
        $user->email_verification_token = Str::random(60);
        
        if (!$user->save()) {
            return back()->withErrors(['error' => 'Gagal menyimpan perubahan']);
        }

        Mail::to($user->email)->send(new AccountConfirmationMail($user, $user->email_verification_token));

        Auth::logout();

        return redirect()->route('login')->with('success', 'Tautan konfirmasi telah dikirim!');
    }

    public function verifyAccount(Request $request, $token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'username' => 'Tautan verifikasi tidak valid atau sudah kadaluarsa.',
            ]);
        }

        $user->markEmailAsVerified();

        return redirect()->route('login')->with('message', 'Akun Anda telah aktif. Silakan login dengan email dan password baru Anda.');
    }
}