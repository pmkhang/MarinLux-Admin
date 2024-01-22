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
        Schema::create('bookings', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('yacht_id');
            $table->foreign('yacht_id')->references('id')->on('yachts');
            $table->unsignedBigInteger('skipper_id')->nullable();
            $table->foreign('skipper_id')->references('id')->on('skippers');
            $table->date('startDate');
            $table->date('endDate');
            $table->integer('guests');
            $table->tinyInteger('location');
            $table->tinyInteger('payment_status')->default(1)->comment("1: Processing, 2: Processed, 3: Cancel");
            $table->tinyInteger('admin_approval_status')->default(1)->comment("1: Processing, 2: Processed, 3 :Cancel");
            $table->tinyInteger('refund_status')->default(1)->comment("1: No process, 2: Processing,3 :Processed");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
