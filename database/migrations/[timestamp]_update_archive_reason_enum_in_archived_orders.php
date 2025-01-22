<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // First, modify the enum values
        DB::statement("ALTER TABLE archived_orders MODIFY COLUMN archive_reason ENUM('completed', 'cancelled') DEFAULT 'completed'");
    }

    public function down()
    {
        // Revert the changes if needed
        DB::statement("ALTER TABLE archived_orders MODIFY COLUMN archive_reason ENUM('deleted', 'completed') DEFAULT 'deleted'");
    }
}; 