<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointment', function (Blueprint $table) {
            if (!Schema::hasColumn('appointment', 'status')) {
                $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled', 'no_show'])
                    ->default('pending');
            }
            
            if (!Schema::hasColumn('appointment', 'created_by_type')) {
                $table->string('created_by_type')->default('user');
            }
            
            if (!Schema::hasColumn('appointment', 'created_by_id')) {
                $table->unsignedBigInteger('created_by_id')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->dropColumn(['status', 'created_by_type', 'created_by_id']);
        });
    }
}; 