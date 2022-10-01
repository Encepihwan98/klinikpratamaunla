<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reseps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rekamedis_id');
            $table->unsignedBigInteger('apoteker_id')->nullable();
            $table->string('status',15);
            $table->date('tgl_resep');
            $table->timestamps();

            $table->foreign('rekamedis_id')
                ->references('id')
                ->on('rekammedis')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('apoteker_id')
                ->references('id')
                ->on('apotekers')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            // $table->foreign('obat_id')
            //     ->references('id')
            //     ->on('obats')
            //     ->onUpdate('cascade')
            //     ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reseps');
    }
}
