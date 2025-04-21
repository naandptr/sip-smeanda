<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    

    const ROLE_ADMIN_UTAMA = 'Admin Utama';
    const ROLE_ADMIN_JURUSAN = 'Admin Jurusan';
    const ROLE_GURU = 'Guru';
    const ROLE_SISWA = 'Siswa';

    const STATUS_PENDING = 'Pending';
    const STATUS_AKTIF = 'Aktif';
    const STATUS_NONAKTIF = 'Nonaktif';

    protected $table = 'tbl_users';

    protected $fillable = [
        'username',
        'email',
        'password',
        'is_default_password',
        'role',
        'status',
        'email_verified_at',  
        'email_verification_token'  
    ];

    protected $hidden = [
        'password',
        'email_verification_token'  
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function generateDefaultPassword()
    {
        return '123456';
    }

    public static function generateSetupToken()
    {
        return Str::random(60);
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isActive()
    {
        return $this->status === self::STATUS_AKTIF;
    }

    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
            'status' => self::STATUS_AKTIF,
            'email_verification_token' => null,
        ])->save();
    }

    // Tambahkan method ini untuk memastikan update bekerja
    public function update(array $attributes = [], array $options = [])
    {
        return parent::update($attributes, $options);
    }

    /**
     * Relasi one-to-one dengan Siswa
     * (Untuk user dengan role Siswa)
     */
    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id', 'id');
    }

    /**
     * Relasi one-to-one dengan Pembimbing
     * (Untuk user dengan role Guru)
     */
    public function pembimbing()
    {
        return $this->hasOne(Pembimbing::class, 'user_id', 'id');
    }

    /**
     * Relasi one-to-one dengan AdminJurusan
     * (Untuk user dengan role Admin Jurusan)
     */
    public function adminJurusan()
    {
        return $this->hasOne(AdminJurusan::class, 'user_id', 'id');
    }

    // ========== METHOD ROLE CHECKER ========== //

    public function isAdminUtama()
    {
        return $this->role === self::ROLE_ADMIN_UTAMA;
    }

    public function isAdminJurusan()
    {
        return $this->role === self::ROLE_ADMIN_JURUSAN;
    }

    public function isGuru()
    {
        return $this->role === self::ROLE_GURU;
    }

    public function isSiswa()
    {
        return $this->role === self::ROLE_SISWA;
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($user) {
    //         if (empty($user->password)) {
    //             $user->password = bcrypt('123456');
    //         }
    //     });
    // }
}
