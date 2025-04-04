<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Twilio\Rest\Client;

class YourVerificationController extends Controller
{
    public function sendVerification($phoneNumber)
    {
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        $serviceSid = env('TWILIO_VERIFY_SERVICE_SID');

        $verification = $twilio->verify->v2->services($serviceSid)
            ->verifications
            ->create($phoneNumber, "sms", [
                'customFriendlyName' => 'VetCare'
            ]);

        // Handle the response from Twilio
        // ...
    }
} 