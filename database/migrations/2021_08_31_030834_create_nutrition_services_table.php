<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNutritionServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutrition_services', function (Blueprint $table) {
            $table->id();
            $table->uuid('service_uuid');
            $table->unsignedBigInteger('treatment_id');
            $table->string('treatment_type');
            $table->unsignedBigInteger('nutrition_id');
            $table->dateTime('treatment_time');
            $table->integer('amount');
            $table->unsignedBigInteger('officer_id');
            $table->timestamps();

            $table->foreign('officer_id')
                ->references('id')
                ->on('employees')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('nutrition_id')
                ->references('id')
                ->on('m_nutritions')
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
        Schema::dropIfExists('nutrition_services');
    }
}
