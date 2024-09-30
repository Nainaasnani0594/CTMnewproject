<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('sponsor_name'); 
            $table->string('project_name'); 
            $table->string('project_manager'); 
            $table->string('contract_holder_country');
            $table->integer('contract_value'); 
            $table->integer('task_done'); 
            $table->integer('task_remain'); 
            $table->string('status'); 
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
