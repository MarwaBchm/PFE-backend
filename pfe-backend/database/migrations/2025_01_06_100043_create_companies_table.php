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
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('firstname'); // First name of the contact person
            $table->string('lastname');  // Last name of the contact person
            $table->string('denomination'); // Company name
            $table->unsignedBigInteger('user_id'); // Foreign key to the users table
            $table->timestamps(); // Created at and updated at timestamps

            // Define the foreign key constraint
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // Cascade deletes if the referenced user is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
