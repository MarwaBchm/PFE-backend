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
    Schema::table('professors', function (Blueprint $table) {
        // Modify an existing column to use enum
        $table->enum('grade', ['Assistant Lecturer Class B', 'Assistant Lecturer Class A', 'Senior Lecturer Class B' , 'Senior Lecturer Class A' , 'Professor'])->default('Assistant Lecturer Class B')->change();
    });
}

public function down()
{
    Schema::table('professors', function (Blueprint $table) {
        // Reverse the changes in the down method
        $table->string('status')->change();
    });
}
};
