<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('medical_record_number')->unique()->nullable();
            $table->dateTime('registration_date')->nullable();
            $table->unsignedBigInteger('identity_number_id')->nullable();
            $table->string('identity_number')->nullable();
            $table->string('name')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->char('gender', 1)->nullable();
            $table->string('blood_group')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('regency_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('village_id')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('merriage_status')->nullable();
            $table->string('partner_name')->nullable();
            $table->string('family_address')->nullable();
            $table->string('family_phone_number')->nullable();
            $table->unsignedBigInteger('agama_id')->nullable();
            $table->unsignedBigInteger('tribe_id')->nullable();
            $table->unsignedBigInteger('education_id')->nullable();
            $table->unsignedBigInteger('proffesion_id')->nullable();
            $table->timestamps();


            $table->foreign('identity_number_id')
                ->references('id')
                ->on('m_identity_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('province_id')
                ->references('id')
                ->on('provinces')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('regency_id')
                ->references('id')
                ->on('regencies')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('district_id')
                ->references('id')
                ->on('districts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('village_id')
                ->references('id')
                ->on('villages')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('agama_id')
                ->references('id')
                ->on('m_agamas')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('tribe_id')
                ->references('id')
                ->on('m_tribes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('education_id')
                ->references('id')
                ->on('m_education')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('proffesion_id')
                ->references('id')
                ->on('m_professions')
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
        Schema::dropIfExists('patients');
    }
}
