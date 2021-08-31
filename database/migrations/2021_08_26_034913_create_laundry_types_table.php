<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaundryTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_laundry_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->timestamps();

            $table->foreign('unit_id')
                ->references('id')
                ->on('m_units')
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
        Schema::dropIfExists('m_laundry_types');
    }
}
