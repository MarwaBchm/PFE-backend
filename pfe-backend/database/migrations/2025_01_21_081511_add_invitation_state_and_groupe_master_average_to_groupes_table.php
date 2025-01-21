<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvitationStateAndGroupeMasterAverageToGroupesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groupes', function (Blueprint $table) {
            // Add the invitation_state column with an enum type
            $table->enum('invitation_state', ['pending', 'accepted', 'refused'])->default('pending');

            // Add the groupe_master_average column as a decimal
            $table->decimal('groupe_master_average', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groupes', function (Blueprint $table) {
            // Drop the columns if the migration is rolled back
            $table->dropColumn('invitation_state');
            $table->dropColumn('groupe_master_average');
        });
    }
}
