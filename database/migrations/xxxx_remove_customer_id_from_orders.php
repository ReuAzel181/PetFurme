<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // First check if the foreign key exists
            $foreignKeys = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableForeignKeys($table->getTable());
            
            foreach ($foreignKeys as $foreignKey) {
                if (in_array('customer_id', $foreignKey->getLocalColumns())) {
                    $table->dropForeign($foreignKey->getName());
                    break;
                }
            }
            
            // Then drop the column
            $table->dropColumn('customer_id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->constrained();
        });
    }
}; 