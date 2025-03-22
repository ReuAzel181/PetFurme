<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('charge_slips', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->string('patient_name');
            $table->string('attending_physician')->nullable();
            $table->decimal('services_total', 10, 2)->default(0);
            $table->decimal('products_total', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->string('discount_type')->default('fixed'); // 'fixed' or 'percentage'
            $table->decimal('grand_total', 10, 2);
            $table->text('notes')->nullable();
            // Store services and products as JSON
            $table->json('services')->nullable();
            $table->json('products')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('charge_slips');
    }
}; 