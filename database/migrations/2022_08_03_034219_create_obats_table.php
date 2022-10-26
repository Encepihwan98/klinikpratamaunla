<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id');
            $table->string('nama',50);
            $table->string('kandungan', 100);
            $table->integer('harga');
            $table->string('satuan',30);
            $table->integer('stock')->nullable();
            $table->text('keterangan');
            $table->timestamps();

            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategori_obats')
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
        Schema::dropIfExists('obats');
    }
}
