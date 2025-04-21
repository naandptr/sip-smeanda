<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PenetapanPrakerin;
use Illuminate\Support\Carbon;

class UpdateStatusPrakerin extends Command
{
    protected $signature = 'prakerin:update-status';

    protected $description = 'Update status prakerin berdasarkan tanggal mulai dan selesai';

    public function handle()
    {
        PenetapanPrakerin::all()->each(function ($penetapan) {
            $now = Carbon::now();

            if ($now->lt($penetapan->tanggal_mulai)) {
                $status = 'Belum Dimulai';
            } elseif ($now->between($penetapan->tanggal_mulai, $penetapan->tanggal_selesai)) {
                $status = 'Berlangsung';
            } else {
                $status = 'Selesai';
            }

            if ($penetapan->status !== $status) {
                $penetapan->update(['status' => $status]);
            }
        });

        $this->info('Status prakerin berhasil diperbarui.');
    }
}
