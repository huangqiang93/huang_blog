<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('links_id');
            $table->char('links_name',50)->default('')->comment('链接名称');
            $table->char('links_url',100)->default('')->comment('链接地址');
            $table->string('links_explain')->default('')->comment('链接说明');
            $table->integer('links_order',3)->default(0)->comment('链接排序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('links');
    }
}
