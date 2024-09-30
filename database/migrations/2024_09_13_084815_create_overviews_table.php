<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('overviews', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->decimal('contract_value', 15, 2);
            $table->decimal('work_done', 15, 2);
            $table->decimal('task_done', 15, 2);
            $table->enum('status', ['Done', 'Work in Progress']);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('overviews');
    }
};
