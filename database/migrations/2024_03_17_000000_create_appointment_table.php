<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointment', function (Blueprint $table) {  // Note: singular 'appointment'
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('owner_name')->nullable();
            $table->string('pet_name');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('reason_for_visit');
            $table->string('status')->default('pending');
            $table->string('created_by_type')->nullable();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('confirmed_by')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Add this if you're using soft deletes
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointment');
    }
}; 