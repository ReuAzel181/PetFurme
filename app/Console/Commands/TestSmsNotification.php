<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Appointment;
use App\Notifications\AppointmentReminder;
use Illuminate\Console\Command;

class TestSmsNotification extends Command
{
    protected $signature = 'test:sms {user_id?}';
    protected $description = 'Test SMS notification';

    public function handle()
    {
        $userId = $this->argument('user_id') ?? 1;
        $user = User::find($userId);

        if (!$user) {
            $this->error('User not found!');
            return 1;
        }

        if (!$user->phone) {
            $this->error('User has no phone number!');
            return 1;
        }

        $appointment = new Appointment([
            'scheduled_at' => now()->addDays(1)
        ]);

        try {
            $user->notify(new AppointmentReminder($appointment));
            $this->info('SMS sent successfully!');
        } catch (\Exception $e) {
            $this->error('Error sending SMS: ' . $e->getMessage());
        }
    }
} 