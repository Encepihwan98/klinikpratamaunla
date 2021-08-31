<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_services', function (Blueprint $table) {
            $table->id();
            $table->uuid('service_uuid');
            $table->unsignedBigInteger('treatment_id');
            $table->string('treatment_type');
            $table->unsignedBigInteger('room_bed_id');
            $table->datetime('entry_time');
            $table->datetime('exit_time')->nullable();
            $table->timestamps();

            $table->foreign('room_bed_id')
                ->references('id')
                ->on('room_beds')
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
        Schema::dropIfExists('room_services');
    }
}
