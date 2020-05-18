<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('user_id')->on('clients');

            $table->boolean('worker_found')->default(0);

            $table->unsignedBigInteger('worker_id')->nullable();
            $table->foreign('worker_id')->references('user_id')->on('workers');

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
        Schema::dropIfExists('ads');
    }
}
