<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponseCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('response_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->text('comment')->nullable();
            $table->string('like')->default(0)->nullable();
            $table->bigInteger('reply_to')->unsigned()->nullable();
            $table->boolean('is_hide')->default(0)->nullable();
            $table->foreign('response_id')->references('id')->on('responses')->onDelete('cascade');
            $table->foreign('reply_to')->references('id')->on('response_comments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('response_comments');
    }
}
