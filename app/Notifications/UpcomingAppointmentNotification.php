<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\NexmoMessage;
use App\Models\Appointment;

class UpcomingAppointmentNotification extends Notification
{
    use Queueable;

    protected $appointment;
    protected $type; // 'day_before' or 'three_hours_before'

    public function __construct(Appointment $appointment, $type)
    {
        $this->appointment = $appointment;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['nexmo']; // This can be changed to use Twilio if desired
    }

    public function toNexmo($notifiable)
    {
        $message = $this->type === 'day_before' 
            ? "Reminder: You have an appointment tomorrow at {$this->appointment->appointment_time} for {$this->appointment->pet_name}."
            : "Reminder: You have an appointment in 3 hours at {$this->appointment->appointment_time} for {$this->appointment->pet_name}.";

        return (new NexmoMessage)
            ->content($message);
    }
} 