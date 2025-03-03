<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->string('owner_name')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->string('owner_name')->nullable(false)->change();
        });
    }
    
};
