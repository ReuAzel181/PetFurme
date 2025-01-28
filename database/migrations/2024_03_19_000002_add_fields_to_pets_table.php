<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pets', function (Blueprint $table) {
            if (!Schema::hasColumn('pets', 'size')) {
                $table->string('size')->nullable();
            }
            if (!Schema::hasColumn('pets', 'gender')) {
                $table->string('gender')->nullable();
            }
            if (!Schema::hasColumn('pets', 'weight')) {
                $table->decimal('weight', 8, 2)->nullable();
            }
            if (!Schema::hasColumn('pets', 'allergies')) {
                $table->text('allergies')->nullable();
            }
            if (!Schema::hasColumn('pets', 'notes')) {
                $table->text('notes')->nullable();
            }
            if (!Schema::hasColumn('pets', 'photo')) {
                $table->string('photo')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn(['size', 'gender', 'weight', 'allergies', 'notes', 'photo']);
        });
    }
}; 