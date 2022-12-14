<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCoinStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_coin_statuses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user1')->unsigned();
            $table->foreign('user1')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('user2')->unsigned()->nullable();
            $table->foreign('user2')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('question_id')->unsigned()->nullable();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->bigInteger('response_id')->unsigned()->nullable();
            $table->foreign('response_id')->references('id')->on('responses')->onDelete('cascade');
            $table->integer('coin')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('status2')->nullable();
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
        Schema::dropIfExists('user_coin_statuses');
    }
}
