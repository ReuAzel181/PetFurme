<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointment', function (Blueprint $table) {  // Note: table name is 'appointment' not 'appointments'
            if (!Schema::hasColumn('appointment', 'status')) {
                $table->string('status')->default('pending')->after('appointment_date');
            }
        });
    }

    public function down()
    {
        Schema::table('appointment', function (Blueprint $table) {
            if (Schema::hasColumn('appointment', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}; 