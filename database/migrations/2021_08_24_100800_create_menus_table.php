<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('slug', 150);
            $table->string('url', 200);
            $table->string('target', 20)->default('_self');
            $table->integer('parrent_id')->nullable();
            $table->integer('order');
            $table->string('route', 100)->nullable();
            $table->string('icon', 100)->nullable();
            $table->string('controller', 100)->nullable();
            $table->string('method', 20);
            $table->string('middleware', 100)->nullable();
            $table->tinyInteger('is_hidden')->default(0);
            $table->tinyInteger('is_api')->default(0);
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
        Schema::dropIfExists('m_menus');
    }
}
