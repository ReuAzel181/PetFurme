<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop existing payment columns if they exist
        Schema::table('orders', function (Blueprint $table) {
            $columns = ['payment_type', 'pay', 'due'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        // Add new payment columns
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'is_paid')) {
                $table->boolean('is_paid')->default(false);
            }
            if (!Schema::hasColumn('orders', 'amount_received')) {
                $table->decimal('amount_received', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('orders', 'change_amount')) {
                $table->decimal('change_amount', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('orders', 'paid_at')) {
                $table->timestamp('paid_at')->nullable();
            }
            if (!Schema::hasColumn('orders', 'payment_note')) {
                $table->text('payment_note')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'is_paid',
                'amount_received',
                'change_amount',
                'paid_at',
                'payment_note'
            ]);

            // Restore original payment columns
            $table->string('payment_type')->nullable();
            $table->decimal('pay', 10, 2)->default(0);
            $table->decimal('due', 10, 2)->default(0);
        });
    }
}; 