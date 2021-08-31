<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_medical_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type');
            $table->string('description');
            $table->timestamps();

            $table->foreign('type')
                ->references('id')
                ->on('m_medical_activity_types')
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
        Schema::dropIfExists('m_medical_activities');
    }
}
