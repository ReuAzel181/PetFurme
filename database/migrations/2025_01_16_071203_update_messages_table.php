<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('sender_id')->after('id');
            $table->unsignedBigInteger('receiver_id')->after('sender_id');
            $table->text('message')->after('receiver_id');
            $table->timestamp('sent_at')->nullable()->after('message');

            // Add foreign keys if sender_id and receiver_id reference other tables
            // For example, if they reference the `users` table:
            // $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['sender_id', 'receiver_id', 'message', 'sent_at']);

            // Drop foreign keys if added
            // $table->dropForeign(['sender_id']);
            // $table->dropForeign(['receiver_id']);
        });
    }
}
