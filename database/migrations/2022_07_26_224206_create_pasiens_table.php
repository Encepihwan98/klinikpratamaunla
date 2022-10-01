<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->string('id',6);
            $table->string('nama',70);
            $table->string('no_ktp',16);
            $table->string('jenis_kelamin',12);
            $table->date('tgl_lahir');
            $table->string('pekerjaan', 50);
            $table->string('no_hp',15);
            $table->text('alamat');
            $table->integer('dokter_id');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasiens');
    }
}
