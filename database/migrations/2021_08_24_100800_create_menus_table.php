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
            $table->uuid('uuid');
            $table->string('name', 150);
            $table->string('slug', 150);
            $table->string('url', 200);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('order');
            $table->string('icon', 150)->nullable();
            $table->string('component');
            $table->string('api_module')->nullable();
            $table->boolean('must_login')->default(false);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_parent')->default(false);
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
