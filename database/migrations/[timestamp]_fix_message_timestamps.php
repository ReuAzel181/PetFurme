<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Fix any messages where sent_at differs from created_at
        DB::table('messages')
            ->whereRaw('sent_at != created_at')
            ->update([
                'sent_at' => DB::raw('created_at'),
                'updated_at' => DB::raw('created_at')
            ]);
    }

    public function down()
    {
        // No need for down method as this is a data fix
    }
}; 