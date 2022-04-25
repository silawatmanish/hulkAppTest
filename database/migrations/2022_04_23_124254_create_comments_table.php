<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id');
            $table->bigInteger('task_id');
            $table->bigInteger('user_id');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
            

            $table->foreign('project_id')->references('id')->on('projects');

            $table->foreign('task_id')->references('id')->to('tasks');

            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
