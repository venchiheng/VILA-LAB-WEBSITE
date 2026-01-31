<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the table if it exists
        Schema::dropIfExists('equipment_bookings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional: recreate the table if needed
        Schema::create('equipment_bookings', function ($table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('equipment_id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->dateTime('booking_date');
            $table->dateTime('approve_date')->nullable();
            $table->dateTime('return_date')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['pending','approved','in_use','overdue','returned','rejected'])->default('pending');
            $table->timestamps();

            // Foreign keys if needed
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }
};
