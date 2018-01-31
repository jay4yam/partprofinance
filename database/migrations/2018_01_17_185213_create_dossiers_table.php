<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDossiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('signature', ['Electronique', 'Physique']);
            $table->enum('objet_du_pret', ['Voitures', 'Moto' , 'Caravane', 'Camping-car', 'Bateaux', 'Travaux']);
            $table->enum('duree_du_pret', [12,24,36,48,60,72,84,96])->default(84);
            $table->decimal('montant_demande');
            $table->decimal('montant_final');
            $table->decimal('taux_commission')->default(12);
            $table->decimal('montant_commission_partpro')->nullable();
            $table->string('apporteur')->nullable();
            $table->enum('status', ['Refusé', 'A l étude', 'Accepté', 'Payé', 'Impayé'])->default('A l étude');
            $table->string('num_dossier_banque')->nullable();
            $table->timestamps();
        });

        Schema::table('dossiers', function (Blueprint $table){
           $table->integer('user_id')->unsigned();
           $table->foreign('user_id')->references('id')->on('users');

            $table->integer('banque_id')->unsigned();
            $table->foreign('banque_id')->references('id')->on('banques');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dossiers', function (Blueprint $table){
            $table->dropForeign('dossiers_user_id_foreign');
            $table->dropForeign('dossiers_banque_id_foreign');

            $table->dropColumn('user_id');
            $table->dropColumn('banque_id');
        });
        Schema::dropIfExists('dossiers');
    }
}