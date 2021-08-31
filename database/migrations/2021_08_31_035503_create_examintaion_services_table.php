<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamintaionServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examintaion_services', function (Blueprint $table) {
            $table->id();
            $table->uuid('service_uuid');
            $table->unsignedBigInteger('treatment_id');
            $table->string('treatment_type');
            $table->unsignedBigInteger('general_examination_id');
            $table->string('examination_result');
            $table->dateTime('treatment_time');
            $table->unsignedBigInteger('officer_id');
            $table->timestamps();

            $table->foreign('general_examination_id')
                ->references('id')
                ->on('m_general_examinations')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('officer_id')
                ->references('id')
                ->on('employees')
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
        Schema::dropIfExists('examintaion_services');
    }
}
