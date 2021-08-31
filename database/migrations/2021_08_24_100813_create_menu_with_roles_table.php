<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuWithRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_with_roles', function (Blueprint $table) {
            $table->foreignId('role_id');
            $table->foreignId('menu_id');
            $table->tinyInteger('is_home')->default(0);
            $table->tinyInteger('create')->default(0);
            $table->tinyInteger('read')->default(0);
            $table->tinyInteger('update')->default(0);
            $table->tinyInteger('delete')->default(0);
            $table->tinyInteger('print')->default(0);
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('m_roles')->onCascade('delete');
            $table->foreign('menu_id')->references('id')->on('m_menus')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_with_roles');
    }
}
