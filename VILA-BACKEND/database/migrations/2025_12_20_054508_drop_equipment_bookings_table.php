<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if foreign key exists before dropping
        $foreignKeys = DB::select("SELECT CONSTRAINT_NAME 
                                   FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                                   WHERE TABLE_SCHEMA = DATABASE() 
                                   AND TABLE_NAME = 'notifications' 
                                   AND COLUMN_NAME = 'booking_id'");

        if (!empty($foreignKeys)) {
            Schema::table('notifications', function ($table) {
                $table->dropForeign(['booking_id']);
            });
        }

        // Drop table safely
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
