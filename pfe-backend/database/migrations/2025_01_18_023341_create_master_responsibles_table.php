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
        Schema::create('master_responsibles', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('professor_id'); // Foreign key to the professors table
            $table->unsignedBigInteger('major_id'); // Foreign key to the majors table
            $table->timestamps(); // Created at and updated at timestamps

            // Define foreign key constraints
            $table->foreign('professor_id')
                  ->references('id')
                  ->on('professors')
                  ->onDelete('cascade'); // Cascade deletes if the referenced professor is deleted

            $table->foreign('major_id')
                  ->references('id')
                  ->on('majors')
                  ->onDelete('cascade'); // Cascade deletes if the referenced major is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_responsibles');
    }
};
