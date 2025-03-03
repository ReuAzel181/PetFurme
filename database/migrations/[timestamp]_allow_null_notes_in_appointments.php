<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllowNullNotesInAppointments extends Migration
{
    public function up()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->text('notes')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->text('notes')->nullable(false)->change();
        });
    }
} 