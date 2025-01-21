<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhasesTable extends Migration
{
    public function up()
    {
        Schema::create('phases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('starting_date');
            $table->date('ending_date');
            $table->boolean('for_professor')->default(false);
            $table->boolean('for_student')->default(false);
            $table->boolean('for_responsible')->default(false);
            $table->boolean('for_company')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phases');
    }
}
