<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOrdersPaymentFields extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_type')->nullable()->change();
            $table->decimal('pay', 10, 2)->nullable()->change();
            $table->decimal('due', 10, 2)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_type')->nullable(false)->change();
            $table->decimal('pay', 10, 2)->nullable(false)->change();
            $table->decimal('due', 10, 2)->nullable(false)->change();
        });
    }
} 