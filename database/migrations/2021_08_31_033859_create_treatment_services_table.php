<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatment_services', function (Blueprint $table) {
            $table->id();
            $table->uuid('service_uuid');
            $table->unsignedBigInteger('treatment_id');
            $table->string('treatment_type');
            $table->unsignedBigInteger('special_treatment_id');
            $table->dateTime('treatment_time');
            $table->integer('amount');
            $table->unsignedBigInteger('officer_id');
            $table->timestamps();

            $table->foreign('officer_id')
                ->references('id')
                ->on('employees')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('special_treatment_id')
                ->references('id')
                ->on('m_special_treatments')
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
        Schema::dropIfExists('treatment_services');
    }
}
