<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Modify product_image to store path
            $table->string('product_image')->nullable()->change();
            
            // Ensure product_image_data exists as MEDIUMBLOB
            if (!Schema::hasColumn('products', 'product_image_data')) {
                $table->mediumBlob('product_image_data')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->mediumBlob('product_image')->nullable()->change();
            $table->dropColumn('product_image_data');
        });
    }
}; 