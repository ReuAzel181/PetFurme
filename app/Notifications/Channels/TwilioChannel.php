<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class TwilioChannel
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.account_sid'),
            config('services.twilio.auth_token')
        );
    }

    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toTwilio')) {
            throw new \Exception('Notification class must implement toTwilio() method.');
        }

        $message = $notification->toTwilio($notifiable);

        if (empty($message)) {
            return;
        }

        $to = $notifiable->routeNotificationForTwilio($notification);

        try {
            $this->client->messages->create($to, [
                'from' => config('services.twilio.phone_number'),
                'body' => $message
            ]);
        } catch (\Exception $e) {
            \Log::error('Twilio SMS Error: ' . $e->getMessage());
        }
    }
} 