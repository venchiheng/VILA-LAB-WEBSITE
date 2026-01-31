
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('membership_applications', function (Blueprint $table) {
            // Drop old columns you don't want anymore
            $table->dropColumn(['cv_path', 'google_form_response_url']);

            // Add new columns
            $table->enum('gender', ['male', 'female', 'other'])->after('full_name');
            $table->string('qualification')->after('email');
            $table->string('faculty')->after('qualification');
            $table->string('year')->after('faculty');
            $table->string('cv_path')->nullable()->after('year');

            $table->text('motivation')->after('cv_path');
            $table->text('time_management')->after('motivation');
            $table->string('availability')->after('time_management');
        });
    }

    public function down(): void
    {
        Schema::table('membership_applications', function (Blueprint $table) {
            // Reverse the changes
            $table->dropColumn(['gender', 'qualification', 'faculty', 'year', 'cv_path', 'motivation', 'time_management', 'availability']);
            $table->string('cv_path')->nullable()->after('email');
            $table->string('google_form_response_url')->nullable()->after('cv_path');
        });
    }
};
