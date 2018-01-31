<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessProspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_prospects', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['non traite', 'nrp', 'faux num', 'intérêt', 'sans suite' ]);
            $table->enum('relance_status', ['relance_1', 'relance_2', 'relance_3'])->nullable();
            $table->date('relance_j1')->nullable();
            $table->date('relance_j4')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::table('process_prospects', function (Blueprint $table){
            $table->integer('temp_prospects_id')->unsigned();
            $table->foreign('temp_prospects_id')->references('id')->on('temp_prospects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('process_prospects', function (Blueprint $table){
            $table->dropForeign('process_prospects_temp_prospects_id_foreign');
            $table->dropColumn('temp_prospects_id');
        });

        Schema::dropIfExists('process_prospects');
    }
}
