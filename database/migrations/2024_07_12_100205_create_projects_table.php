<?php

use App\Models\User;
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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('sponsor_name');
            $table->string('project_name');
            $table->string('contract_holder_country');
            $table->string('project_manager');
            $table->string('currency', 3);
            $table->integer('contract_value', false, true);
            $table->boolean('contract_signed');
            $table->string('billing_type');
            $table->date('activity_start_date');
            $table->date('billing_start_date');
            $table->float('clinical_duration', 5, 2);
            $table->float('study_duration', 5, 2);
            $table->integer('patients');
            $table->integer('sites');
            $table->boolean('status');
            $table->smallInteger('phase');
            $table->string('therapeutic_area');
            $table->string('sponsor_country');
            $table->foreignIdFor(User::class, 'created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
