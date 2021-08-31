<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMidWifeServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mid_wife_services', function (Blueprint $table) {
            $table->id();
            $table->uuid('service_uuid');
            $table->unsignedBigInteger('treatment_id');
            $table->string('treatment_type');
            $table->unsignedBigInteger('medical_activity_id');
            $table->integer('amount')->default(1);
            $table->dateTime('treatment_time');
            $table->unsignedBigInteger('officer_id');
            // $table->text('tarif')->nullable();
            $table->timestamps();

            $table->foreign('officer_id')
                ->references('id')
                ->on('employees')
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
        Schema::dropIfExists('mid_wife_services');
    }
}
