<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeDetailServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_detail_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('medicine_id');
            $table->integer('amount')->default(1);
            $table->string('rules');
            $table->dateTime('treatment_time');
            $table->unsignedBigInteger('office_id');
            $table->timestamps();

            $table->foreign('recipe_id')
                ->references('id')
                ->on('recipe_services')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('office_id')
                ->references('id')
                ->on('employees')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('medicine_id')
                ->references('id')
                ->on('logistics')
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
        Schema::dropIfExists('recipe_detail_services');
    }
}
