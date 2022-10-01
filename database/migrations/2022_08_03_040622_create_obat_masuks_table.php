<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObatMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obat_masuks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obat_id');
            $table->unsignedBigInteger('suplier_id');
            $table->integer('jumlah_masuk');
            $table->date('tgl');
            $table->timestamps();

            $table->foreign('obat_id')
                ->references('id')
                ->on('obats')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('suplier_id')
                ->references('id')
                ->on('supliers')
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
        Schema::dropIfExists('obat_masuks');
    }
}
