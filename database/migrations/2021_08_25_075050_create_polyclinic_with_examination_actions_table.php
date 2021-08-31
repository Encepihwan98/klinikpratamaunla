<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolyclinicWithExaminationActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polyclinic_examination_actions', function (Blueprint $table) {
            $table->unsignedBigInteger('polyclinic_id');
            $table->unsignedBigInteger('examination_action_id');
            $table->timestamps();

            $table->primary(['polyclinic_id', 'examination_action_id'],
                'polyclinic_with_examination_actions_id_primary'
            );

            $table->foreign('polyclinic_id')
                ->references('id')
                ->on('polyclinics')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('examination_action_id')
                ->references('id')
                ->on('m_examination_actions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polyclinic_with_examination_actions');
    }
}
