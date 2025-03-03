<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'uuid')) {
                $table->uuid('uuid')->after('id')->unique();
            }
        });

        // Generate UUIDs for existing products
        DB::table('products')->whereNull('uuid')->each(function ($product) {
            DB::table('products')
                ->where('id', $product->id)
                ->update(['uuid' => Str::uuid()]);
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
}; 