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
            $table->string('pet_type')->nullable(); // Pet type (e.g., Dog, Cat)
            $table->integer('pet_age')->nullable(); // Pet age
        });
    }
    
    public function down()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->dropColumn('pet_type');
            $table->dropColumn('pet_age');
        });
    }
    
};
