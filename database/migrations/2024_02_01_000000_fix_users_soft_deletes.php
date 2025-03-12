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

        // First, drop the table if it exists
        Schema::dropIfExists('users');

        // Recreate the table with the correct structure
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('pet_owner');
            $table->string('username')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('photo')->nullable();
            $table->string('store_name')->nullable();
            $table->string('store_address')->nullable();
            $table->string('store_email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down()
    {
        // First, disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::dropIfExists('users');

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}; 