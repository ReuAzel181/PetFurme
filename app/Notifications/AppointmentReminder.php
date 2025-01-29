<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\TwilioChannel;

class AppointmentReminder extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        // Only send SMS if user has enabled SMS notifications
        if ($notifiable->settings?->sms_notifications) {
            return [TwilioChannel::class];
        }
        return [];
    }

    public function toTwilio($notifiable)
    {
        $phoneNumber = $notifiable->phone; // Assuming this is how you access the phone number
        \Log::info('Sending SMS to:', ['to' => $phoneNumber]); // Log the phone number

        // Include appointment details and pet's name in the message
        return "Hi {$notifiable->name}, this is a reminder for your appointment for {$this->appointment->pet_name} on " . 
               $this->appointment->scheduled_at->format('M d, Y h:i A') . 
               " at PetCare Veterinary Clinic.";
    }
} 