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
        Schema::create('yacht_specifications', function (Blueprint $table) {
            $table->id();
            $table->string('yacht_id');
            $table->foreign('yacht_id')->references('id')->on('yachts')->onDelete('cascade');;
            $table->integer('cabin');
            $table->integer('length');
            $table->integer('beam');
            $table->integer('speed');
            $table->integer('crew');
            $table->integer('year');
            $table->string('builder');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yacht_specifications');
    }
};
