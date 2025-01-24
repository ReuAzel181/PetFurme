<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop the table if it exists
        Schema::dropIfExists('archived_appointments');

        Schema::create('archived_appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('pet_id')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('pet_name')->nullable();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->text('reason_for_visit');
            // Archive specific fields
            $table->enum('status', ['completed', 'cancelled'])->default('cancelled');
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('archived_appointments');
    }
}; 