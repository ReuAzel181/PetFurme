<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Check if column exists first
        $hasColumn = DB::select("
            SELECT COUNT(*) as count 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = 'users' 
            AND COLUMN_NAME = 'deleted_at'", 
            [env('DB_DATABASE')]
        )[0]->count > 0;

        if (!$hasColumn) {
            // Add the column if it doesn't exist
            DB::statement('ALTER TABLE users ADD COLUMN deleted_at timestamp NULL DEFAULT NULL');
        }

        // Create index if it doesn't exist
        $hasIndex = DB::select("
            SELECT COUNT(*) as count 
            FROM information_schema.STATISTICS 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = 'users' 
            AND INDEX_NAME = 'users_deleted_at_index'", 
            [env('DB_DATABASE')]
        )[0]->count > 0;

        if (!$hasIndex) {
            DB::statement('CREATE INDEX users_deleted_at_index ON users (deleted_at)');
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['deleted_at']);
            $table->dropColumn('deleted_at');
        });
    }
}; 