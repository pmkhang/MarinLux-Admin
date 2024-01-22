<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $sqlFilePath = base_path('marin-lux-2.sql');
        DB::unprepared(file_get_contents($sqlFilePath));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
