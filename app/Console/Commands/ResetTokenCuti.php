<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ResetTokenCuti extends Command
{

    protected $signature = 'cuti:reset';
    protected $description = 'Reset token cuti setiap awal tahun';

    public function handle()
    {
        User::query()->update([
            'token_cuti' => 12 // bisa di ubah sesuai kebijakan
        ]);

        $this->info('Token cuti berhasil direset untuk semua user.');
    }

}
