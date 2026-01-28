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
       Schema::table('equipment', function (Blueprint $table) {
            // Change enum values
            $table->enum('availability', ['available', 'booked'])
                  ->default('available')
                  ->change();

            // Add new column
            $table->text('condition')->nullable()->after('availability');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('equipment', function (Blueprint $table) {
            // Revert enum
            $table->enum('availability', ['available', 'unavailable', 'maintenance'])
                  ->default('available')
                  ->change();

            // Drop condition column
            $table->dropColumn('condition');
        });
    }
};
