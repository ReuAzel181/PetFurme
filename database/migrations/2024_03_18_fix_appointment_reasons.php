<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Appointment;

class FixAppointmentReasons extends Migration
{
    public function up()
    {
        // Fix the malformed reason_for_visit data
        $appointments = Appointment::whereNotNull('reason_for_visit')->get();
        
        foreach ($appointments as $appointment) {
            try {
                $reasons = $appointment->reason_for_visit;
                
                // If it's a string, try to decode it
                if (is_string($reasons)) {
                    $reasons = json_decode($reasons, true);
                }
                
                // Clean up the reasons array
                if (is_array($reasons)) {
                    $cleanReasons = [];
                    foreach ($reasons as $reason) {
                        if (is_string($reason)) {
                            // Remove extra brackets and quotes
                            $reason = trim($reason, '[]"');
                            if (!empty($reason)) {
                                $cleanReasons[] = $reason;
                            }
                        }
                    }
                    
                    // Save the cleaned reasons
                    $appointment->reason_for_visit = json_encode($cleanReasons);
                    $appointment->save();
                }
            } catch (\Exception $e) {
                \Log::error('Error fixing appointment reasons:', [
                    'appointment_id' => $appointment->id,
                    'original_reasons' => $appointment->reason_for_visit,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    public function down()
    {
        // No rollback needed
    }
} 