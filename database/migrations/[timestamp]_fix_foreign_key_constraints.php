<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First, drop foreign key constraints
        Schema::table('pets', function (Blueprint $table) {
            // Get the foreign key constraint name
            $foreignKeys = $this->listTableForeignKeys('pets');
            foreach($foreignKeys as $key) {
                $table->dropForeign($key);
            }
        });

        // Now run your migrations
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_paid')->default(false);
            $table->decimal('amount_received', 10, 2)->nullable();
            $table->decimal('change_amount', 10, 2)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('payment_note')->nullable();
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
        });
    }

    private function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();
        return array_map(function($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }
}; 