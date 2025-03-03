<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('checkup_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->constrained()->onDelete('cascade');
            $table->string('category');
            $table->date('checkup_date');
            $table->text('results')->nullable();
            $table->text('existing_symptoms')->nullable();
            $table->text('current_medication')->nullable();
            $table->text('new_medication')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkup_histories');
    }
};