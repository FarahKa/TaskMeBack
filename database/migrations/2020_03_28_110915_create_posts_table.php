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
            $table->bigIncrements('id');

            $table->unsignedBigInteger('task_id');
            $table->foreign('task_id')->references('id')->on('tasks');

            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('user_id')->on('clients');

            $table->boolean('worker_found')->default(0);

            $table->unsignedBigInteger('worker_id')->nullable();
            $table->foreign('worker_id')->references('user_id')->on('workers');

            $table->double('price')->default(0);

            $table->timestamps();
            $table->timestamp('date')->nullable();
            $table->text('description');

            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses');

            $table->text('issues')->nullable();
            $table->boolean('state')->default(false);
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
