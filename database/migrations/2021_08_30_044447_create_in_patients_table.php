<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('in_patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_bed_id');
            $table->datetime('entry_time');
            $table->datetime('exit_time')->nullable();
            $table->unsignedBigInteger('medical_activity_id');
            $table->string('admission');
            $table->unsignedBigInteger('activity_type');
            $table->string('final_condition')->nullable();
            $table->string('drop_out_condition');
            $table->string('reference')->nullable();
            $table->string('destination_hospital')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('room_bed_id')
                ->references('id')
                ->on('room_beds')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('medical_activity_id')
                ->references('id')
                ->on('m_medical_activities')
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
        Schema::dropIfExists('in_patients');
    }
}
