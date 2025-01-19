<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check and add missing columns to appointment table
        if (!Schema::hasColumn('appointment', 'reason_for_visit')) {
            Schema::table('appointment', function (Blueprint $table) {
                $table->text('reason_for_visit')->nullable();
            });
        }

        // Check and add missing columns to products table
        if (!Schema::hasColumn('products', 'quantity_alert')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('quantity_alert')->default(10);
            });
        }

        // Add any other missing columns here
    }

    public function down()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->dropColumn('reason_for_visit');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('quantity_alert');
        });
    }
}; 