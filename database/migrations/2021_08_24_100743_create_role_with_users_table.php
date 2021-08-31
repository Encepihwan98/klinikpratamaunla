<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleWithUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_with_users', function (Blueprint $table) {
            $table->foreignId('role_id');
            $table->foreignId('user_id');
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('m_roles')->onCascade('delete');
            $table->foreign('user_id')->references('id')->on('users')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_with_users');
    }
}
