<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Notifications\UpcomingAppointmentNotification;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';
    protected $description = 'Send SMS reminders for upcoming appointments';

    public function handle()
    {
        // Get appointments for tomorrow
        $tomorrowAppointments = Appointment::where('appointment_date', Carbon::tomorrow()->format('Y-m-d'))
            ->where('status', 'confirmed')
            ->get();

        foreach ($tomorrowAppointments as $appointment) {
            if ($appointment->user && $appointment->user->phone) {
                $appointment->user->notify(new UpcomingAppointmentNotification($appointment, 'day_before'));
            }
        }

        // Get appointments in 3 hours
        $threeHoursFromNow = Carbon::now()->addHours(3);
        $appointmentsInThreeHours = Appointment::where('appointment_date', Carbon::today()->format('Y-m-d'))
            ->where('status', 'confirmed')
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(appointment_time, ?)) <= 10800", [$threeHoursFromNow->format('H:i:s')])
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(appointment_time, ?)) >= 10740", [$threeHoursFromNow->format('H:i:s')])
            ->get();

        foreach ($appointmentsInThreeHours as $appointment) {
            if ($appointment->user && $appointment->user->phone) {
                $appointment->user->notify(new UpcomingAppointmentNotification($appointment, 'three_hours_before'));
            }
        }
    }
} 