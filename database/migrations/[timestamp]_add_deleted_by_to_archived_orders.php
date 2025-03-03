<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('archived_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('archived_orders', 'deleted_by')) {
                $table->foreignId('deleted_by')->nullable()->constrained('users');
            }
        });
    }

    public function down()
    {
        Schema::table('archived_orders', function (Blueprint $table) {
            $table->dropForeign(['deleted_by']);
            $table->dropColumn('deleted_by');
        });
    }
}; 