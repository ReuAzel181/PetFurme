<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('users', 'uuid')) {
                $table->uuid('uuid')->unique()->after('id');
            }
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('uuid');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('pet_owner')->after('password');
            }
            if (!Schema::hasColumn('users', 'verified')) {
                $table->boolean('verified')->default(false)->after('role');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable()->after('password');
            }
            // Add any other missing columns here
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove columns in reverse order
            $table->dropColumn([
                'verified',
                'role',
                'username',
                'uuid',
                'phone',
                'address',
                'photo'
            ]);
        });
    }

    public function change()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('address')->nullable()->change();
        });
    }
}; 