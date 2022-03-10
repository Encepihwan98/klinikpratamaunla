<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportActionServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_action_services', function (Blueprint $table) {
            $table->id();
            $table->uuid('service_uuid');
            $table->unsignedBigInteger('support_id');
            $table->unsignedBigInteger('action_id');
            $table->string('action_type');
            $table->dateTime('action_time');
            $table->integer('amount')->default(1);
            $table->string('note')->nullable();
            $table->unsignedBigInteger('officer_id');
            $table->string('rate');
            $table->timestamps();

            $table->foreign('officer_id')
                ->references('id')
                ->on('employees')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('support_id')
                ->references('id')
                ->on('support_services')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_action_services');
    }
}
