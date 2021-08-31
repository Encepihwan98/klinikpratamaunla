<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reception_id')->nullable();
            $table->unsignedBigInteger('polyclinic_id');
            $table->unsignedBigInteger('logistic_id');
            $table->integer('amount');
            $table->integer('price')->default(0);
            $table->timestamps();

            $table->foreign('reception_id')
                ->references('id')
                ->on('receptions')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('polyclinic_id')
                ->references('id')
                ->on('polyclinics')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('logistic_id')
                ->references('id')
                ->on('logistics')
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
        Schema::dropIfExists('logistic_transactions');
    }
}
