<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'emailUser' => 'required|email|exists:tbl_users,email',
        ]);

        $token = Str::random(60);
        $email = $request->emailUser;

        DB::table('tbl_password_resets')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::to($email)->send(new ResetPasswordMail($token));

        return back()->with('message', 'Tautan reset password telah dikirim ke email Anda.');
    }

    public function showResetForm($token)
    {
        return view('auth.ganti_password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'new-pw' => 'required|string|min:6',
            'confirm-pw' => 'required|same:new-pw',
            'token' => 'required',
        ]);

        $resetData = DB::table('tbl_password_resets')->where('token', $request->token)->first();

        if (!$resetData || Carbon::parse($resetData->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['error' => 'Token tidak valid atau sudah kadaluarsa.']);
        }

        $user = User::where('email', $resetData->email)->first();

        if (!$user) {
            return back()->withErrors(['error' => 'Pengguna tidak ditemukan.']);
        }

        $user->password = Hash::make($request->input('new-pw'));
        $user->is_default_password = false;
        $user->save();

        DB::table('tbl_password_resets')->where('email', $user->email)->delete();

        return redirect()->route('login')->with('message', 'Password berhasil diperbarui. Silakan login.');
    }
}
