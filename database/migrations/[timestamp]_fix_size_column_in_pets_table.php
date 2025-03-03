<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pets', function (Blueprint $table) {
            // First make it nullable
            if (Schema::hasColumn('pets', 'size')) {
                $table->string('size')->nullable()->change();
            }
            
            // Then remove it
            $table->dropColumn('size');
        });
    }

    public function down()
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->string('size')->nullable();
        });
    }
}; 