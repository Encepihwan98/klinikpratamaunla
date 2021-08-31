<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_general_examinations', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->unsignedBigInteger('unit');
            $table->unsignedBigInteger('period');
            $table->timestamps();

            $table->foreign('unit')
                  ->references('id')
                  ->on('m_units')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('period')
                  ->references('id')
                  ->on('m_periods')
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
        Schema::dropIfExists('m_general_examinations');
    }
}
