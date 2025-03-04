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
            $response = $this->supabase->from('conversations')->select('*')->execute();

            // Log the entire response for debugging
            \Log::info('Supabase getConversations response:', (array) $response);

            // Check if the response has an error
            if (isset($response->error)) {
                // Log the error details
                \Log::error('Supabase getConversations error:', (array) $response->error);
                throw new \Exception($response->error->message ?? 'Unknown error');
            }

            return $response->data; // Return the conversations data
        } catch (\Exception $e) {
            // Log the exception message and stack trace
            \Log::error('Error in getConversations: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
            ]);
            return ['error' => $e->getMessage()];
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
            $response = $this->supabase
                ->from('messages')
                ->insert([
                    'sender_id' => $sender_id,
                    'receiver_id' => $receiver_id,
                    'message' => $message,
                    'sent_at' => now(),
                ])
                ->execute();

            // Log the entire response for debugging
            \Log::info('Supabase sendMessage response:', (array) $response);

            // Check if the response has an error
            if (isset($response->error)) {
                // Log the error details
                \Log::error('Supabase sendMessage error:', (array) $response->error);
                throw new \Exception('Supabase Insert Error: ' . ($response->error->message ?? 'Unknown error'));
            }

            return $response->data;
        } catch (\Exception $e) {
            // Log the exception message and stack trace
            \Log::error('Error in sendMessage: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
            ]);
            throw $e; // Rethrow the exception for further handling
        }
    }
}
