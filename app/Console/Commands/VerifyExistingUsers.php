<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class VerifyExistingUsers extends Command
{
    protected $signature = 'users:verify-all';
    protected $description = 'Verify all existing users';

    public function handle()
    {
        $count = User::whereNull('email_verified_at')
            ->update(['email_verified_at' => now()]);

        $this->info("{$count} users have been verified.");
    }
} 