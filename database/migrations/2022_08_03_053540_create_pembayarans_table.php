<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('regis_id');
            $table->unsignedBigInteger('resep_id');
            $table->integer('total_bayar');
            $table->integer('jumlah_bayar');
            $table->date('tgl_bayar');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('regis_id')
                ->references('id')
                ->on('registrasi_pasiens')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            
            $table->foreign('resep_id')
                ->references('id')
                ->on('reseps')
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
        Schema::dropIfExists('pembayarans');
    }
}
