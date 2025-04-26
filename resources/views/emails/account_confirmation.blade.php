<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Akun - Sistem Informasi Prakerin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #004080;
            color: #ffffff;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            color: #333333;
            line-height: 1.5;
        }
        .button {
            display: inline-block;
            background: #004080;
            color: #ffffff;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Verifikasi Akun 
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $user->username }}</strong>,</p>
            <p>Terima kasih telah mendaftar di <strong>Sistem Informasi Prakerin</strong>. Untuk mengaktifkan akun Anda, silakan verifikasi email dengan mengklik tombol di bawah ini:</p>
            <p style="text-align: center;">
                <a class="button" href="{{ url('/verify-account/' . $user->email_verification_token) }}">Verifikasi Akun</a>
            </p>
            <p>Jika Anda tidak merasa mendaftar di sistem ini, harap abaikan email ini.</p>
            <p>Salam,</p>
            <p><strong>Admin Sistem Informasi Prakerin</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Sistem Informasi Prakerin. All rights reserved.
        </div>
    </div>
</body>
</html>
