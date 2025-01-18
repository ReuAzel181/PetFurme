<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateMessagesToConversations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:messages-to-conversations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing messages to conversations structure';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $messages = DB::table('messages')->get();

        foreach ($messages as $message) {
            // Create a unique conversation for each sender-receiver pair
            $uniqueKey = $message->sender_id . '-' . $message->receiver_id;

            $conversation = DB::table('conversations')->updateOrInsert(
                [
                    'unique_key' => $uniqueKey, // Use unique_key for uniqueness
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Get the conversation ID
            $conversationId = DB::table('conversations')
                ->where('unique_key', $uniqueKey)
                ->value('id');

            // Update the message with the conversation ID
            DB::table('messages')->where('id', $message->id)->update(['conversation_id' => $conversationId]);
        }

        $this->info('Messages successfully migrated to conversations!');
    }

}
