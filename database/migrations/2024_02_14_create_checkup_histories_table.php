<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // First, disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Drop and recreate the table
        Schema::dropIfExists('checkup_histories');

        Schema::create('checkup_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id');
            $table->string('category');
            $table->date('checkup_date');
            $table->text('results')->nullable();
            $table->text('existing_symptoms')->nullable();
            $table->text('current_medication')->nullable();
            $table->text('new_medication')->nullable();
            $table->timestamps();

            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
        });

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down()
    {
        // First, disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Schema::dropIfExists('checkup_histories');
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};