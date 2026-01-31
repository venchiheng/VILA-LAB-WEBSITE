<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_bookings', function (Blueprint $table) {
            $table->id();

            // Who made the booking (member)
            $table->unsignedBigInteger('user_id');

            // Who approved the booking (admin)
            $table->unsignedBigInteger('approved_by')->nullable();

            // Which equipment is booked
            $table->unsignedBigInteger('equipment_id');

            // Booking dates
            $table->dateTime('booking_date');
            $table->dateTime('approve_date')->nullable();
            $table->dateTime('return_date')->nullable();

            // Booking status
            $table->enum('status', [
                'pending',
                'approved',
                'in_use',
                'overdue',
                'returned',
                'rejected'
            ])->default('pending');

            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('equipment_id')->references('id')->on('equipment')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_bookings');
    }
};
