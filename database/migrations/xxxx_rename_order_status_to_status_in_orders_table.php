<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // First check if status exists
            if (!Schema::hasColumn('orders', 'status')) {
                // If order_status exists, rename it
                if (Schema::hasColumn('orders', 'order_status')) {
                    $table->renameColumn('order_status', 'status');
                } else {
                    // If neither exists, create status column
                    $table->string('status')->default('pending');
                }
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'status')) {
                $table->renameColumn('status', 'order_status');
            }
        });
    }
}; 