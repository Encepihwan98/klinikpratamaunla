<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id');
            $table->unsignedBigInteger('registration_type_id')->nullable();
            $table->unsignedBigInteger('perawatan_id')->nullable();
            $table->string('perawatan_type')->nullable();
            $table->text('rate')->nullable();
            $table->timestamps();

            $table->foreign('registration_type_id')
                ->references('id')
                ->on('m_registration_patient_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('visit_id')
                ->references('id')
                ->on('visits')
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
        Schema::dropIfExists('registrations');
    }
}
