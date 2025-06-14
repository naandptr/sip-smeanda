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
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'emailUser' => 'required|email',
        ]);

        $email = $request->emailUser;

        $user = User::where('email', $email)->first(); 

        if (!$user) {
            return response()->json([
                'errors' => [
                    'emailUser' => ['Email tidak terdaftar.']
                ]
            ], 422);
        }

        DB::table('tbl_password_resets')->where('email', $email)->delete();

        $token = Str::random(60);

        DB::table('tbl_password_resets')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::to($email)->send(new ResetPasswordMail($user, $token));

        return response()->json([
            'message' => 'Tautan pemulihan kata sandi telah dikirim ke email Anda.'
        ]);
    }

    public function showResetForm($token)
    {
        $resetData = DB::table('tbl_password_resets')->where('token', $token)->first();

        if (!$resetData || Carbon::parse($resetData->created_at)->addMinutes(60)->isPast()) {
            return redirect()->route('lupa-password')->with('error', 'Tautan pemulihan sudah tidak berlaku. Silakan minta tautan baru.');
        }

        return view('auth.ganti_password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new-pw' => [
                'required',
                'string',
                'min:8', 
                'regex:/[a-zA-Z]/', 
                'regex:/[0-9]/', 
            ],
            'confirm-pw' => 'required|same:new-pw',
            'token' => 'required',
        ], [
            'new-pw.min' => 'Kata sandi minimal harus 8 karakter.',
            'new-pw.regex' => 'Kata sandi harus mengandung huruf dan angka.',
            'confirm-pw.same' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi baru.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $resetData = DB::table('tbl_password_resets')->where('token', $request->token)->first();

        if (!$resetData || Carbon::parse($resetData->created_at)->addMinutes(60)->isPast()) {
            return response()->json([
                'success' => false,
                'errors' => ['Tautan pemulihan sudah tidak berlaku. Silakan minta tautan baru.'],
            ], 400);
        }

        $user = User::where('email', $resetData->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'errors' => ['Pengguna tidak ditemukan.'],
            ], 404);
        }

        $user->password = Hash::make($request->input('new-pw'));
        $user->is_default_password = false;
        $user->save();

        DB::table('tbl_password_resets')->where('email', $user->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kata sandi berhasil diperbarui. Silakan masuk.',
            'redirect' => route('login'),
        ]);
        
    }
}
