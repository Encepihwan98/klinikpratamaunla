<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolyclinicRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polyclinic_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('polyclinic_id');
            $table->string('name');
            $table->string('type');
            $table->unsignedBigInteger('grade_id');
            $table->timestamps();

            $table->foreign('polyclinic_id')
                ->references('id')
                ->on('polyclinics')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('grade_id')
                ->references('id')
                ->on('m_room_grades')
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
        Schema::dropIfExists('polyclinic_rooms');
    }
}
