<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('orders', 'is_paid')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->boolean('is_paid')->default(false);
            });
        }

        if (!Schema::hasColumn('orders', 'amount_received')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('amount_received', 10, 2)->nullable();
            });
        }

        if (!Schema::hasColumn('orders', 'change_amount')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('change_amount', 10, 2)->nullable();
            });
        }

        if (!Schema::hasColumn('orders', 'paid_at')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->timestamp('paid_at')->nullable();
            });
        }

        if (!Schema::hasColumn('orders', 'payment_note')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->text('payment_note')->nullable();
            });
        }
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
        });
    }
}; 