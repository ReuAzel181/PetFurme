<?php

namespace App\Services;

use Supabase\CreateClient;

class MessageService
{
    protected $supabase;

    public function __construct()
    {
        $this->supabase = new CreateClient(
            config('supabase.url'),  // Supabase URL from config
            config('supabase.key')   // Supabase API key from config
        );
    }

    public function getConversations()
    {
        try {
            // Check if there are conversations
            $response = $this->supabase
                ->from('conversations')
                ->select('*') // Select all columns
                ->execute();

            // Log the response for debugging
            \Log::info('Supabase getConversations response:', (array) $response);

            // Return data if the query is successful
            if ($response->status === 200) {
                return $response->data ?? [];
            }

            // Return an empty array if no data
            return [];
        } catch (\Exception $e) {
            // Log the error and throw it
            \Log::error('Error in getConversations: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createConversation($name)
    {
        try {
            // Insert a new conversation
            $response = $this->supabase
                ->from('conversations')
                ->insert([
                    'name' => $name,
                    'created_at' => now(),
                ])
                ->execute();

            // Log the response for debugging
            \Log::info('Supabase createConversation response:', (array) $response);

            return $response->data;
        } catch (\Exception $e) {
            // Log the error and throw it
            \Log::error('Error in createConversation: ' . $e->getMessage());
            throw $e;
        }
    }

    public function sendMessage($sender_id, $receiver_id, $message)
    {
        try {
            // Attempt to insert the message
            $response = $this->supabase
                ->from('messages')
                ->insert([
                    'sender_id' => $sender_id,
                    'receiver_id' => $receiver_id,
                    'message' => $message,
                    'sent_at' => now(),
                ])
                ->execute();

            // Log the response for debugging
            \Log::info('Supabase sendMessage response:', (array) $response);

            // Check if the response has an error
            if (isset($response->error)) {
                \Log::error('Supabase Insert Error: ' . json_encode($response->error));
                throw new \Exception('Supabase Insert Error: ' . $response->error['message']);
            }

            return $response->data;
        } catch (\Exception $e) {
            // Log the error and throw it
            \Log::error('Error in sendMessage: ' . $e->getMessage());
            throw $e;
        }
    }
}
