<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->datetime('visit_in');
            $table->datetime('visit_out')->nullable();
            $table->string('visit_number')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('case_id')->nullable();
            $table->unsignedBigInteger('disease_id')->nullable();
            $table->unsignedBigInteger('reference_type_id')->nullable();
            $table->string('origin_reference')->nullable();
            $table->string('reference_number')->nullable();
            $table->date('reference_date')->nullable();
            $table->string('pj_name')->nullable();
            $table->string('pj_phone_number')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->string('sjp_number')->nullable();
            $table->date('sjp_date')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('case_id')
                ->references('id')
                ->on('m_case_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('disease_id')
                ->references('id')
                ->on('m_diseases')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('reference_type_id')
                ->references('id')
                ->on('m_reference_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('payment_method_id')
                ->references('id')
                ->on('m_payment_methods')
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
        Schema::dropIfExists('visits');
    }
}
