<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // First recreate the orders table with all required columns
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->date('order_date');
                $table->integer('total_products');
                $table->decimal('sub_total', 10, 2);
                $table->decimal('vat', 10, 2);
                $table->decimal('total', 10, 2);
                $table->string('invoice_no');
                $table->string('reference')->nullable();
                $table->boolean('is_paid')->default(false);
                $table->decimal('amount_received', 10, 2)->nullable();
                $table->decimal('change_amount', 10, 2)->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->text('payment_note')->nullable();
                $table->timestamps();
            });
        } else {
            // Add payment columns to existing table
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'is_paid')) {
                    $table->boolean('is_paid')->default(false)->after('total');
                }
                if (!Schema::hasColumn('orders', 'amount_received')) {
                    $table->decimal('amount_received', 10, 2)->nullable()->after('is_paid');
                }
                if (!Schema::hasColumn('orders', 'change_amount')) {
                    $table->decimal('change_amount', 10, 2)->nullable()->after('amount_received');
                }
                if (!Schema::hasColumn('orders', 'paid_at')) {
                    $table->timestamp('paid_at')->nullable()->after('change_amount');
                }
                if (!Schema::hasColumn('orders', 'payment_note')) {
                    $table->text('payment_note')->nullable()->after('paid_at');
                }
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