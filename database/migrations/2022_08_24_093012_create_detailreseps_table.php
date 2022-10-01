<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailresepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailreseps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resep_id');
            $table->unsignedBigInteger('obat_id');
            $table->text('keterangan');
            $table->integer('jumlah');
            $table->integer('harga');
            $table->timestamps();

            $table->foreign('obat_id')
                ->references('id')
                ->on('obats')
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
        Schema::dropIfExists('detailreseps');
    }
}
