<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipment_bookings', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['user_id']); // <-- important

            // Now drop the user_id column
            $table->dropColumn('user_id');

            // Add new columns
            $table->string('member_id', 20)->after('id');
            $table->string('full_name')->after('member_id');
            $table->text('purpose')->nullable()->after('full_name');
            $table->integer('quantity')->default(1)->after('purpose');
        });
    }

    public function down(): void
    {
        Schema::table('equipment_bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->dropColumn(['member_id', 'full_name', 'purpose', 'quantity']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
