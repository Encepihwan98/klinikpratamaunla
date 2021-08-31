<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('out_patients', function (Blueprint $table) {
            $table->id();
            $table->datetime('entry_time');
            $table->datetime('exit_time')->nullable();
            $table->unsignedBigInteger('final_condition')->nullable();
            $table->unsignedBigInteger('medical_activity_id');
            $table->unsignedBigInteger('polyclinic_id');
            $table->boolean('is_emergency');
            $table->timestamps();

            $table->foreign('medical_activity_id')
                ->references('id')
                ->on('m_medical_activities')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('polyclinic_id')
                ->references('id')
                ->on('polyclinics')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('out_patients');
    }
}
