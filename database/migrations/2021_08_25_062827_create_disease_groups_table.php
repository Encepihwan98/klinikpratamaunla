<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiseaseGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_disease_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classification_id');
            $table->string('icd')->unique();
            $table->string('description');
            $table->timestamps();

            $table->foreign('classification_id')
                ->references('id')
                ->on('m_disease_classifications')
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
        Schema::dropIfExists('m_disease_groups');
    }
}
