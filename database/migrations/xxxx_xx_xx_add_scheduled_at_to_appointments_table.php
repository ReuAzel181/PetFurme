<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->dateTime('scheduled_at')->nullable()->after('appointment_time');
            
            // Add a trigger to automatically set scheduled_at
            DB::unprepared('
                CREATE TRIGGER set_scheduled_at_trigger 
                BEFORE INSERT ON appointment
                FOR EACH ROW
                SET NEW.scheduled_at = CONCAT(NEW.appointment_date, " ", NEW.appointment_time)
            ');
            
            // Update existing records
            DB::statement('
                UPDATE appointment 
                SET scheduled_at = CONCAT(appointment_date, " ", appointment_time)
                WHERE scheduled_at IS NULL
            ');
        });
    }

    public function down()
    {
        Schema::table('appointment', function (Blueprint $table) {
            // Remove trigger first
            DB::unprepared('DROP TRIGGER IF EXISTS set_scheduled_at_trigger');
            
            $table->dropColumn('scheduled_at');
        });
    }
}; 