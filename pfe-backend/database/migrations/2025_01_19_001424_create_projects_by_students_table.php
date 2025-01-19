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
        Schema::create('project_by_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_grp')->constrained('groupes')->onDelete('cascade');
            $table->json('materials'); // Store materials as JSON array
            $table->string('type');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_by_students');
    }
};
