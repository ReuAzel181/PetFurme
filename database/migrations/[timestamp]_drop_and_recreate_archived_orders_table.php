<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First drop the archived_order_details table since it depends on archived_orders
        Schema::dropIfExists('archived_order_details');
        
        // Then drop the archived_orders table
        Schema::dropIfExists('archived_orders');

        // Recreate archived_orders table
        Schema::create('archived_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('original_id');
            $table->unsignedBigInteger('user_id');
            $table->string('customer_name');
            $table->datetime('order_date');
            $table->integer('total_products');
            $table->decimal('sub_total', 10, 2);
            $table->decimal('vat', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('invoice_no');
            $table->text('note')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->decimal('amount_received', 10, 2)->default(0);
            $table->decimal('change_amount', 10, 2)->default(0);
            $table->timestamp('paid_at')->nullable();
            $table->text('payment_note')->nullable();
            $table->string('archive_reason')->default('completed'); // Changed to string instead of enum
            $table->text('archive_note')->nullable();
            $table->timestamp('archived_at');
            $table->timestamps();
            
            $table->index(['archive_reason', 'archived_at']);
        });

        // Recreate archived_order_details table
        Schema::create('archived_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('archived_order_id')->constrained('archived_orders')->onDelete('cascade');
            $table->string('product_name');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('archived_order_details');
        Schema::dropIfExists('archived_orders');
    }
}; 