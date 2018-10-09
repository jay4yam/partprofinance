<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFkToTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tasks');

        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('task_creator_user_id')->unsigned();
            $table->date('taskdate');
            $table->text('taskcontent');
            $table->enum('level', ['very high', 'high', 'normal', 'low']);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::table('tasks', function(Blueprint $table){
            $table->integer('prospect_id')->unsigned();
            $table->foreign('prospect_id')->references('id')->on('prospects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function(Blueprint $table){
            $table->dropForeign('tasks_prospect_id_foreign')->unsigned();
            $table->dropColumn('prospect_id');
        });

        Schema::dropIfExists('tasks');
    }
}
