<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_paid')->default(false);
            $table->decimal('amount_received', 10, 2)->nullable();
            $table->decimal('change_amount', 10, 2)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('payment_note')->nullable();
            $table->string('order_status')->default('pending');
            $table->timestamp('completed_at')->nullable();
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
                'payment_note',
                'order_status',
                'completed_at'
            ]);
        });
    }
}; 