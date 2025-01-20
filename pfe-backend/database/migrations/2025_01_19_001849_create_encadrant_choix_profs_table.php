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
        Schema::create('encadrant_choix_profs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prof_id')->constrained('professors')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->tinyInteger('nombre_de_choix')->unsigned()->check('nombre_de_choix < 10');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encadrant_choix_profs');
    }
};
