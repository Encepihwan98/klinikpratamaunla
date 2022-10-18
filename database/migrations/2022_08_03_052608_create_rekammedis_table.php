<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekammedisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekammedis', function (Blueprint $table) {
            $table->id();
            $table->string('pasien_id',6);
            $table->unsignedBigInteger('registrasi_id');
            $table->bigInteger('dokter_id')->unsigned();
            $table->string('tindakan_id', 15)->nullable();
            $table->integer('bb');
            $table->integer('tb');
            $table->integer('tensi');
            $table->text('keluhan')->nullable();
            $table->text('anamnesis')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tgl');
            $table->timestamps();

            // $table->foreign('pasien_id')
            //     ->references('id')
            //     ->on('pasiens')
            //     ->onUpdate('cascade')
            //     ->onDelete('restrict');

            $table->foreign('dokter_id')
                ->references('id')
                ->on('dokters')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('registrasi_id')
                ->references('id')
                ->on('registrasi_pasiens')
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
        Schema::dropIfExists('rekammedis');
    }
}
