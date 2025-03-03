<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Appointment;
use App\Notifications\AppointmentReminder;
use Illuminate\Console\Command;

class TestAppointmentNotification extends Command
{
    protected $signature = 'test:appointment-notification {appointment_id}';
    protected $description = 'Test SMS notification for a specific appointment';

    public function handle()
    {
        $appointmentId = $this->argument('appointment_id');
        $appointment = Appointment::find($appointmentId);

        if (!$appointment) {
            $this->error('Appointment not found!');
            return 1;
        }

        if (!$appointment->user || !$appointment->user->phone) {
            $this->error('User has no phone number!');
            return 1;
        }

        // Log the details before sending the notification
        \Log::info('Sending SMS for appointment ID: ' . $appointmentId);
        \Log::info('Sending SMS to: ' . $appointment->user->phone);

        // Log the user's SMS notification settings
        \Log::info('User SMS Notifications Setting:', [
            'user_id' => $appointment->user->id,
            'sms_notifications' => $appointment->user->settings?->sms_notifications
        ]);

        try {
            $appointment->user->notify(new AppointmentReminder($appointment));
            $this->info('SMS sent successfully!');
        } catch (\Exception $e) {
            \Log::error('Error sending SMS: ' . $e->getMessage());
            $this->error('Error sending SMS: ' . $e->getMessage());
        }
    }
} 