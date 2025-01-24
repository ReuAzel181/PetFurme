<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Drop any existing migrations that might have failed
        $migrations = DB::table('migrations')
            ->where('migration', 'like', '%add_deleted_by_to_orders%')
            ->get();
            
        foreach ($migrations as $migration) {
            DB::table('migrations')->where('id', $migration->id)->delete();
        }

        Schema::table('orders', function (Blueprint $table) {
            // Drop the column if it exists (just in case)
            if (Schema::hasColumn('orders', 'deleted_by')) {
                $table->dropForeign(['deleted_by']);
                $table->dropColumn('deleted_by');
            }
            
            // Add the column fresh
            $table->unsignedBigInteger('deleted_by')->nullable()->after('deletion_reason');
            $table->foreign('deleted_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['deleted_by']);
            $table->dropColumn('deleted_by');
        });
    }
}; 