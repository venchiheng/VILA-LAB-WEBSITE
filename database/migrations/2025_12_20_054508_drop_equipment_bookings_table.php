<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop foreign key first
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['booking_id']); // use the column name in notifications table
        });

        // Now drop the table
        Schema::dropIfExists('equipment_bookings');
    }

    public function down(): void
    {
        // Optionally, recreate the table if needed
        Schema::create('equipment_bookings', function (Blueprint $table) {
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

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }
};
