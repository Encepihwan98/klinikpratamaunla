<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_services', function (Blueprint $table) {
            $table->id();
            $table->uuid('service_uuid');
            $table->unsignedBigInteger('treatment_id');
            $table->string('treatment_type');
            $table->unsignedBigInteger('examination_action_id');
            $table->integer('amount');
            $table->dateTime('treatment_time');
            $table->unsignedBigInteger('officer_id');
            $table->timestamps();

            $table->foreign('officer_id')
                ->references('id')
                ->on('employees')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('examination_action_id')
                ->references('id')
                ->on('m_examination_actions')
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
        Schema::dropIfExists('action_services');
    }
}
