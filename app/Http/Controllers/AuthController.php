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
use Illuminate\Validation\Rule;

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

        $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
            return back()->withErrors(['username' => 'Akun tidak ditemukan.']);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            Auth::logout(); 
            return back()->withErrors(['password' => 'Kata sandi salah.']);
        }

        if (!$user->hasVerifiedEmail()) {
            Auth::login($user);
            return redirect()->route('setup-akun');
        }

        if ($user->is_default_password) {
            Auth::login($user); 
            return redirect()->route('ganti-password-awal');
        }

        if ($user->status !== User::STATUS_AKTIF) {
            Auth::logout();
            return back()->withErrors(['username' => 'Akun dinonaktifkan.']);
        }

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
            'emailUser' => [
            'required',
            'email',
            Rule::unique('tbl_users', 'email')->ignore($user->id, 'id'),
        ],
        ], [
            'emailUser.required' => 'Email wajib diisi.',
            'emailUser.email' => 'Format email tidak valid.',
            'emailUser.unique' => 'Email sudah digunakan oleh pengguna lain.',
        ]);

        $user->email = $validated['emailUser'];
        $user->email_verification_token = Str::random(60);
        
        if (!$user->save()) {
            return back()->withErrors(['error' => 'Gagal menyimpan perubahan.']);
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
                'username' => 'Tautan verifikasi sudah tidak berlaku. Silakan minta tautan baru.',
            ]);
        }

        $user->markEmailAsVerified();

        return redirect()->route('login')->with('message', 'Akun Anda telah diverifikasi. Silakan masuk.');
    }

    public function changePasswordFormAwal()
    {
        return view('auth.ganti_password_awal'); 
    }

    public function changePasswordAwal(Request $request)
    {
        $request->validate([
            'new-pw' => [
                'required',
                'string',
                'min:8', 
                'regex:/[a-z]/', 
                'regex:/[0-9]/', 
            ],
            'confirm-pw' => 'required|same:new-pw',
        ], [
            'new-pw.min' => 'Kata sandi minimal harus 8 karakter.',
            'new-pw.regex' => 'Kata sandi harus mengandung huruf dan angka.',
            'confirm-pw.same' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi baru.',
        ]);

        /** @var \App\Models\User $user */

        $user = Auth::user();
        $user->password = Hash::make($request->input('new-pw'));
        $user->is_default_password = false;
        $user->save();

        Auth::logout();

        return redirect()->route('login')->with('message', 'Kata sandi berhasil diubah. Silakan masuk.');
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
            'new-pw' => [
                'required',
                'string',
                'min:8', 
                'regex:/[a-z]/', 
                'regex:/[0-9]/', 
            ],
            'confirm-pw' => 'required|string',
        ],[
            'new-pw.min' => 'Kata sandi minimal harus 8 karakter.',
            'new-pw.regex' => 'Kata sandi harus mengandung huruf dan angka.',
        ]);

        if ($request->input('new-pw') !== $request->input('confirm-pw')) {
            return response()->json([
                'message' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi baru'
            ], 400);
        }

        /** @var \App\Models\User $user */
        $user = Auth::guard('web')->user();

        if (!Hash::check($request->input('old-pw'), $user->password)) {
            return response()->json([
                'message' => 'Kata sandi lama tidak sesuai'
            ], 400);
        }

        $user->password = Hash::make($request->input('new-pw'));
        $user->is_default_password = false;
        $user->save();

        return response()->json([
            'message' => 'Kata sandi berhasil diperbarui',
            'redirect_to' => route('akun.show')
        ]);
    }
}