<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // First check if foreign key exists and drop it if it does
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = 'orders'
            AND CONSTRAINT_TYPE = 'FOREIGN KEY'
            AND CONSTRAINT_NAME LIKE '%deleted_by%'
        ", [env('DB_DATABASE')]);

        foreach ($foreignKeys as $foreignKey) {
            Schema::table('orders', function (Blueprint $table) use ($foreignKey) {
                $table->dropForeign($foreignKey->CONSTRAINT_NAME);
            });
        }

        // Now modify the column to ensure it has the correct properties
        Schema::table('orders', function (Blueprint $table) {
            // Modify the existing column instead of trying to create it
            $table->foreignId('deleted_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['deleted_by']);
            // Make it a simple nullable bigint
            $table->unsignedBigInteger('deleted_by')->nullable()->change();
        });
    }
}; 