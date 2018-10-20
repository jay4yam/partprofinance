<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDossierTableToManyPolymorphic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dossierables', function (Blueprint $table){
            $table->increments('dossier_id');
            $table->integer('dossierable_id')->unsigned();
            $table->string('dossierable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dossierables');
    }
}
