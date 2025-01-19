<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('project_by_professors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_prof')->constrained('professors')->onDelete('cascade');
            $table->foreignId('id_coencadrant')->constrained('professors')->onDelete('cascade');
            $table->string('type');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_by_professors');
    }
};
