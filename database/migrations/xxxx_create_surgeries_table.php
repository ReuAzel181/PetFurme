<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surgeries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('pet_id')->constrained()->onDelete('cascade');
            $table->string('surgery_type'); // spay_neuter, minor, major
            $table->text('pre_surgery_notes')->nullable();
            $table->text('anesthesia_used');
            $table->text('procedure_notes');
            $table->text('recovery_notes');
            $table->text('post_surgery_care');
            $table->date('follow_up_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surgeries');
    }
}; 