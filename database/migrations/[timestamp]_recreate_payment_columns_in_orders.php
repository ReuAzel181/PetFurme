<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // First check if the columns exist
        $hasColumns = DB::select("
            SELECT COUNT(*) as count 
            FROM information_schema.columns 
            WHERE table_schema = DATABASE()
            AND table_name = 'orders' 
            AND column_name = 'is_paid'
        ");

        // Only add columns if they don't exist
        if ($hasColumns[0]->count == 0) {
            DB::statement('
                ALTER TABLE orders 
                ADD COLUMN is_paid BOOLEAN DEFAULT FALSE,
                ADD COLUMN amount_received DECIMAL(10,2) NULL,
                ADD COLUMN change_amount DECIMAL(10,2) NULL,
                ADD COLUMN paid_at TIMESTAMP NULL,
                ADD COLUMN payment_note TEXT NULL
            ');
        }
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = ['is_paid', 'amount_received', 'change_amount', 'paid_at', 'payment_note'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}; 