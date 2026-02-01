<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop foreign key first if notifications table exists
        if (Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                if (Schema::hasColumn('notifications', 'booking_id')) {
                    $table->dropForeign(['booking_id']);
                }
            });
        }

        // Now drop the equipment_bookings table safely
        if (Schema::hasTable('equipment_bookings')) {
            Schema::dropIfExists('equipment_bookings');
        }
    }

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
