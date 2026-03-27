# SIP-Smeanda
### Sistem Informasi Prakerin — Laravel 11

> Platform manajemen Praktik Kerja Industri (Prakerin) berbasis web untuk SMK, mencakup pengelolaan pengguna, dokumen, presensi, jurnal, dan penilaian siswa.

---

## Daftar Isi

- [Tentang Aplikasi](#tentang-aplikasi)
- [Fitur Utama](#fitur-utama)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi & Setup](#instalasi--setup)
- [Akun Default](#akun-default)
- [Peran & Hak Akses](#peran--hak-akses)
- [Ringkasan Rute](#ringkasan-rute)
- [Console Command](#console-command)
- [Mail / Email](#mail--email)
- [PDF Generation](#pdf-generation)
- [Pengembangan & Tips](#pengembangan--tips)
- [Perintah Artisan Berguna](#perintah-artisan-berguna)
- [Struktur Database](#struktur-database)

---

## Tentang Aplikasi

**SIP-Smeanda** adalah aplikasi Laravel 11 untuk mengelola alur kerja Praktik Kerja Industri (Prakerin) di SMK. Aplikasi ini mendukung empat peran pengguna — Admin Utama, Admin Jurusan, Guru, dan Siswa — dengan fitur lengkap mulai dari pengelolaan dokumen, presensi harian, jurnal kegiatan, hingga penilaian dan ekspor PDF.

---

## Fitur Utama

- **Role-based Access Control** — Admin Utama, Admin Jurusan, Guru, Siswa (via `spatie/laravel-permission`)
- **Verifikasi Email** — Aktivasi akun melalui email verification
- **Upload & Download Dokumen** — Manajemen dokumen siswa prakerin
- **Presensi & Jurnal** — Pencatatan kehadiran dan jurnal harian siswa
- **Penilaian** — Input nilai dan ekspor PDF (via `barryvdh/laravel-dompdf`)
- **Status Prakerin Otomatis** — Console command untuk update status berdasarkan tanggal
- **Reset Password** — Alur lupa password via email

---

## Persyaratan Sistem

| Komponen | Versi |
|---|---|
| PHP | ^8.2 |
| Composer | Terbaru |
| Database | MySQL / SQLite / lainnya (didukung Laravel) |

### Paket Composer Utama

| Paket | Fungsi |
|---|---|
| `laravel/framework ^11.0` | Framework utama |
| `laravel/sanctum` | API authentication |
| `barryvdh/laravel-dompdf` | Export PDF penilaian |
| `spatie/laravel-permission` | Manajemen role & permission |

---

## Instalasi & Setup

### 1. Clone Repository
```bash
git clone <repository-url>
cd sip-smeanda
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Buat File Environment
```bash
cp .env.example .env
```
Edit `.env` dan sesuaikan konfigurasi database dan mail:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sip_smeanda
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

> **Menggunakan SQLite?**
> ```bash
> touch database/database.sqlite
> ```
> Atur `DB_CONNECTION=sqlite` di `.env`.

### 4. Generate App Key
```bash
php artisan key:generate
```

### 5. Jalankan Migrasi & Seeder
```bash
php artisan migrate
php artisan db:seed
```

Seeder akan membuat satu akun admin default (lihat [Akun Default](#akun-default)).

### 8. Jalankan Aplikasi
```bash
php artisan serve
```
Buka `http://127.0.0.1:8000` di browser.

---

## Akun Default

Setelah menjalankan `php artisan db:seed`, akun berikut tersedia:

| Field | Value |
|---|---|
| **Username** | `adminutama` |
| **Password** | `123456` |
| **Role** | Admin Utama |
| **Status** | Pending |
| **is_default_password** | `true` (wajib ganti password saat login pertama) |

> ⚠️ Segera ganti password default setelah login pertama kali.

---

## Peran & Hak Akses

Peran pengguna didefinisikan sebagai konstanta di `app/Models/User.php`:

| Peran | Deskripsi |
|---|---|
| `Admin Utama` | Kelola seluruh data master: user, tahun ajar, jurusan, kelas, lokasi |
| `Admin Jurusan` | Kelola siswa, dokumen, DUDI, dan penetapan prakerin per jurusan |
| `Guru` | Input presensi, jurnal, penilaian, download PDF penilaian |
| `Siswa` | Lihat info prakerin, upload dokumen, isi presensi & jurnal |

**Status Pengguna:**
- `Pending` — Akun baru/belum diaktivasi
- `Aktif` — Akun aktif
- `Nonaktif` — Akun dinonaktifkan

---

## Ringkasan Rute

### Publik / Autentikasi
```
GET|POST  /login
POST      /logout
GET|POST  /lupa-password
GET|POST  /reset-password/{token}
GET       /verify-account/{token}
GET|POST  /setup-akun
GET|POST  /ganti-password-awal
```

### Terproteksi (per Peran)

| Peran | Rute |
|---|---|
| Admin Utama | `/kelola-user`, `/kelola-tahun-ajar`, `/kelola-jurusan`, `/kelola-kelas`, `/kelola-lokasi` |
| Admin Jurusan | `/siswa-jurusan`, `/dokumen-siswa`, `/dudi-jurusan`, `/kelola-prakerin` |
| Guru | Presensi, jurnal, penilaian, download PDF |
| Siswa | Info prakerin, upload dokumen, presensi, jurnal |

Lihat `routes/web.php` untuk detail lengkap.

---

## Console Command

### `prakerin:update-status`

File: `app/Console/Commands/UpdateStatusPrakerin.php`

Memperbarui status `PenetapanPrakerin` secara otomatis berdasarkan tanggal:

| Kondisi | Status |
|---|---|
| Sekarang < `tanggal_mulai` | `Belum Dimulai` |
| Antara `tanggal_mulai` dan `tanggal_selesai` | `Berlangsung` |
| Sekarang > `tanggal_selesai` | `Selesai` |

**Jalankan manual:**
```bash
php artisan prakerin:update-status
```

**Jadwalkan otomatis** — tambahkan ke `app/Console/Kernel.php`:
```php
$schedule->command('prakerin:update-status')->daily();
```
Atau tambahkan ke cron server:
```
0 0 * * * php /path/to/artisan prakerin:update-status
```

---

## Mail / Email

File mail tersedia di `app/Mail/`:
- `AccountConfirmationMail.php` — Verifikasi akun baru
- `ResetPasswordMail.php` — Reset password

Pastikan konfigurasi mail di `.env` sudah benar sebelum menguji alur verifikasi dan reset password.

---

## PDF Generation

`barryvdh/laravel-dompdf` digunakan untuk mengekspor PDF penilaian siswa.

> Pastikan ekstensi PHP `ext-gd` atau `imagick` tersedia jika PDF memerlukan gambar/logo.

---

## Pengembangan & Tips

- Setelah seeder, login sebagai `adminutama` dan selesaikan setup akun (ganti password default).
- Atur `APP_DEBUG=false` dan `APP_URL` yang benar saat deploy ke production.
- Pastikan tidak ada credentials/secrets yang ter-commit ke version control — gunakan `.env`.
- Konfigurasi queue worker dan scheduler jika menggunakan fitur antrian.

### File Kunci untuk Dipelajari

| File | Deskripsi |
|---|---|
| `app/Models/User.php` | Definisi peran & status |
| `routes/web.php` | Semua rute aplikasi dan middleware |
| `app/Console/Commands/UpdateStatusPrakerin.php` | Console command status prakerin |
| `database/seeders/AdminSeeder.php` | Seeder admin default |
| `app/Mail/` | Template email |
| `app/Helpers/helpers.php` | Custom helper functions |

---

## Perintah Artisan Berguna

```bash
# Migrasi
php artisan migrate
php artisan migrate:fresh --seed

# Seeder
php artisan db:seed

# Console command
php artisan prakerin:update-status

# Debugging
php artisan tinker
php artisan route:list

# Cache
php artisan config:cache
php artisan cache:clear

# Queue (jika digunakan)
php artisan queue:work
```

---

## Struktur Database

Migrasi tersedia di `database/migrations/`. Tabel menggunakan prefix `tbl_*`.

Model domain utama di `app/Models/`:
`Siswa`, `Pembimbing`, `Dudi`, `PenetapanPrakerin`, `Penilaian`, `Jurnal`, `Presensi`, `Dokumen`, dan lainnya.

---
