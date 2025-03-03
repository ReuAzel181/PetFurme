<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('archived_orders', function (Blueprint $table) {
            $table->string('archive_reason', 20)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('archived_orders', function (Blueprint $table) {
            // Revert to original definition if needed
            $table->string('archive_reason', 10)->nullable()->change();
        });
    }
}; 