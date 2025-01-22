<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First check if column exists
        if (!Schema::hasColumn('orders', 'order_status')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('order_status')->default('pending')->after('total');
            });
        }
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'order_status')) {
                $table->dropColumn('order_status');
            }
        });
    }
}; 