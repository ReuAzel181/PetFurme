<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First check if the column exists
        if (!Schema::hasColumn('orders', 'deleted_by')) {
            // Drop any existing foreign key constraints that might conflict
            $foreignKeys = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableForeignKeys('orders');
            
            foreach ($foreignKeys as $foreignKey) {
                if (in_array('deleted_by', $foreignKey->getLocalColumns())) {
                    Schema::table('orders', function (Blueprint $table) use ($foreignKey) {
                        $table->dropForeign($foreignKey->getName());
                    });
                }
            }

            // Add the column and foreign key
            Schema::table('orders', function (Blueprint $table) {
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign('deleted_by')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null');
            });
        }
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['deleted_by']);
            $table->dropColumn('deleted_by');
        });
    }
}; 