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

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'username' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     Log::info('Login attempt for: '.$credentials['username']);

    //     $user = User::where('username', $credentials['username'])->first();

    //     if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
    //         Log::info('Auth attempt successful, user: '.Auth::user()->username);
    //         return redirect()->intended(route('dashboard'));
    //     } else {
    //         Log::warning('Auth attempt failed for: '.$credentials['username']);
    //         return back()->withErrors(['username' => 'Login gagal']);
    //     }
        

    //     if (!Hash::check($credentials['password'], $user->password)) {
    //         Log::warning('Password mismatch for: '.$user->username);
    //         return back()->withErrors(['password' => 'Password salah']);
    //     }
        
    //     Log::info('Password match for user: '.$user->username);
        
    //     if ($user->role !== User::ROLE_ADMIN_UTAMA && !$user->hasVerifiedEmail()) {
    //         return back()->withErrors(['email' => 'Email belum diverifikasi']);
    //     }

    //     Auth::login($user);

    //     if ($user->status === User::STATUS_PENDING) {
    //         Log::info('Redirecting user to setup account: '.$user->username);
    //         Log::info('User status saat login: ' . json_encode($user->status));
    //         return redirect()->route('setup-akun');
    //     } else {
    //         Log::info('User status is not pending: '.$user->username);
    //     }
        
    //     if ($user->status !== User::STATUS_AKTIF) {
    //         Log::warning('User  account is inactive: '.$user->username);
    //         return back()->withErrors(['username' => 'Akun dinonaktifkan']);
    //     }

    //     return redirect()->intended(route('dashboard'));
    // }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan username
        $user = User::where('username', $credentials['username'])->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return back()->withErrors(['username' => 'Akun tidak ditemukan.']);
        }

        // Jika password salah
        if (!Hash::check($credentials['password'], $user->password)) {
            Auth::logout(); // Logout pengguna jika password salah
            return back()->withErrors(['password' => 'Password salah']);
        }

        // Cek apakah email sudah diverifikasi
        if (!$user->hasVerifiedEmail()) {
            Auth::login($user); // Login user untuk proses setup akun
            return redirect()->route('setup-akun');
        }

        // Cek apakah password masih default
        if ($user->is_default_password) {
            Auth::login($user); // Login user untuk ganti password awal
            return redirect()->route('ganti-password-awal');
        }

        // Cek apakah status akun aktif
        if ($user->status !== User::STATUS_AKTIF) {
            Auth::logout();
            return back()->withErrors(['username' => 'Akun dinonaktifkan']);
        }

        // Kalau semua valid, login user dan arahkan ke dashboard
        Auth::login($user);
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
        if (!Auth::check()) {
            Log::warning('User  is not authenticated, redirecting to login.');
            return redirect()->route('login');
        }
    
        $user = Auth::user();
        Log::info('User accessing setup form: '.$user->username.' with status: '.$user->status);
    
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
            // 'newPw' => 'required|string|min:6',
            // 'confirmPw' => 'required|same:newPw',
        ]);

        $user->email = $validated['emailUser'];
        // $user->password = Hash::make($validated['newPw']);
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

        return redirect()->route('login')->with('message', 'Akun Anda telah diverifikasi.');
    }

    public function changePasswordFormAwal()
    {
        return view('auth.ganti_password_awal'); 
    }

    public function changePasswordAwal(Request $request)
    {
        $request->validate([
            'new-pw' => 'required|string|min:6',
            'confirm-pw' => 'required|same:new-pw',
        ]);

        /** @var \App\Models\User $user */

        $user = Auth::user();
        $user->password = Hash::make($request->input('new-pw'));
        $user->is_default_password = false;
        $user->save();

        Auth::logout();

        return redirect()->route('login')->with('message', 'Password berhasil diubah. Silakan login.');
    }

    public function showLupaPasswordForm()
    {
        return view('auth.lupa_password');

    }

    public function showAccount()
    {
        $user = Auth::user();
        return view('akun.akun', compact('user'));
    }

    public function changePasswordForm()
    {
        return view('akun.ganti_password'); 
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old-pw' => 'required|string',
            'new-pw' => 'required|string|min:6',
            'confirm-pw' => 'required|string',
        ]);

        if ($request->input('new-pw') !== $request->input('confirm-pw')) {
            return response()->json([
                'message' => 'Konfirmasi password tidak cocok dengan password baru.'
            ], 400);
        }

        /** @var \App\Models\User $user */
        $user = Auth::guard('web')->user();

        if (!Hash::check($request->input('old-pw'), $user->password)) {
            return response()->json([
                'message' => 'Password lama tidak sesuai.'
            ], 400);
        }

        $user->password = Hash::make($request->input('new-pw'));
        $user->is_default_password = false;
        $user->save();

        return response()->json([
            'message' => 'Password berhasil diperbarui.',
            'redirect_to' => route('akun.show')
        ]);
    }
}