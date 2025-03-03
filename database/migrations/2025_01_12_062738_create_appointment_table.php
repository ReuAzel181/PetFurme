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
        if (!Schema::hasTable('appointment')) {
            Schema::create('appointment', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->foreignId('pet_id')->nullable()->constrained('pets')->onDelete('cascade');
                $table->string('owner_name')->nullable();
                $table->date('appointment_date');
                $table->time('appointment_time');
                $table->text('reason_for_visit');
                $table->timestamps();
            });
        }
    }
    
    public function down()
    {
        Schema::dropIfExists('appointment');
    }
    
    
};
