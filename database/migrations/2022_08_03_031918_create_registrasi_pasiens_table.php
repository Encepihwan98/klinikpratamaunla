<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrasiPasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrasi_pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('pasien_id', 6);
            $table->unsignedBigInteger('dokter_id');
            $table->string('jenis_pembayaran');
            $table->string('status',20);
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrasi_pasiens');
    }
}
