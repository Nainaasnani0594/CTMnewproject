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
        Schema::table('overviews', function (Blueprint $table) {
            $table->decimal('task_done', 15, 2)->after('work_done')->nullable();  // Add 'task_done' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overviews', function (Blueprint $table) {
            $table->dropColumn('task_done');  // Remove 'task_done' column
        });
    }
};
