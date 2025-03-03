<?php

namespace App\Services;

use Supabase\SupabaseClient;
use Supabase\CreateClient; // Correct class import

class SupabaseService
{
    protected $supabase;

    public function sendMessage($sender_id, $receiver_id, $message)
    {
        try {
            $response = $this->supabase->from('messages')->insert([
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'message' => $message,
                'sent_at' => now(),
            ]);

            if ($response->error) {
                throw new \Exception($response->error->message);
            }

            return $response->data; // Return the data or success response
        } catch (\Exception $e) {
            // Handle the exception and maybe log it
            return ['error' => $e->getMessage()];
        }
    }

    public function getMessages($user_id)
    {
        try {
            $response = $this->supabase->from('messages')
                ->select('*')
                ->eq('sender_id', $user_id)
                ->or('receiver_id', $user_id)
                ->order('sent_at', 'asc')
                ->execute();

            if ($response->error) {
                throw new \Exception($response->error->message);
            }

            return $response->data; // Return the messages data
        } catch (\Exception $e) {
            // Handle the exception and maybe log it
            return ['error' => $e->getMessage()];
        }
    }
}
