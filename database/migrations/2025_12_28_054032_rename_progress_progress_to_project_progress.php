<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::rename('progress_progress', 'project_progress');
    }

    public function down()
    {
        Schema::rename('project_progress', 'progress_progress');
    }
};
