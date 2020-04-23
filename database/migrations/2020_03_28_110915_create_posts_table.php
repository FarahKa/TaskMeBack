<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('task_id');

            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');

            $table->integer('worker_id')->unsigned();
            $table->foreign('worker_id')->references('id')->on('workers');

            $table->timestamps();
            $table->timestamp('date');
            $table->timestamp('description');

            $table->integer('address_id')->unsigned();
            $table->foreign('address_id')->references('id')->on('addresses');

            $table->text('issues');
            $table->boolean('state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
