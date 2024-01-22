<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('yacht_images', function (Blueprint $table) {
            $table->id();
            $table->string('yacht_id');
            $table->foreign('yacht_id')->references('id')->on('yachts')->onDelete('cascade');;
            $table->text('image');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yacht_images');
    }
};
