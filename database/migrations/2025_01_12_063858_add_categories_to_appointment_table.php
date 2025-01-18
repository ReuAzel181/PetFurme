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
        Schema::table('appointment', function (Blueprint $table) {
            $table->json('categories')->nullable(); // Store categories as JSON
        });
    }
    
    public function down()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->dropColumn('categories');
        });
    }
    
};
