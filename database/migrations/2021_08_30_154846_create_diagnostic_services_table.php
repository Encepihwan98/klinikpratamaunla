<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostic_services', function (Blueprint $table) {
            $table->id();
            $table->uuid('service_uuid');
            $table->unsignedBigInteger('treatment_id');
            $table->string('treatment_type');
            $table->unsignedBigInteger('disease_id');
            $table->string('long_suffering')->nullable();
            $table->unsignedTinyInteger('cases');
            $table->unsignedBigInteger('diagnostic_type_id');
            $table->dateTime('treatment_time');
            $table->unsignedBigInteger('officer_id');
            $table->timestamps();

            $table->foreign('disease_id')
                ->references('id')
                ->on('m_diseases')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('diagnostic_type_id')
                ->references('id')
                ->on('m_diagnosis_types')
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
        Schema::dropIfExists('diagnostic_services');
    }
}
