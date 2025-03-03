<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->json('reason_for_visit')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->json('reason_for_visit')->nullable(false)->change();
        });
    }
}; 