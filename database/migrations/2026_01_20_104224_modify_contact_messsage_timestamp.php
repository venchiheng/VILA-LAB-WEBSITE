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
        Schema::table('contact_messages', function (Blueprint $table) {
            // Remove the old created_at column if it exists
            if (Schema::hasColumn('contact_messages', 'created_at')) {
                $table->dropColumn('created_at');
            }

            // Add created_at and updated_at with automatic timestamps
            $table->timestamps(); // Laravel will create created_at and updated_at automatically
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            // Drop timestamps if rolling back
            $table->dropTimestamps();

            // Optional: recreate just created_at as nullable if needed
            $table->datetime('created_at')->nullable();
        });
    }
};
