<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempProspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_prospects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prospect_source');
            $table->string('nom');
            $table->string('email');
            $table->string('prenom')->nullable();
            $table->string('date_de_naissance')->nullable();
            $table->string('adresse')->nullable();
            $table->string('adresse_2')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('ville')->nullable();
            $table->string('tel_professionnel')->nullable();
            $table->string('situation_familiale')->nullable();
            $table->string('nombre_denfants_a_charge')->nullable();
            $table->string('votre_profession')->nullable();
            $table->string('type_de_votre_contrat')->nullable();
            $table->string('depuis_contrat_mois')->nullable();
            $table->double('votre_salaire')->nullable();
            $table->string('lgmt_depuis_mois')->nullable();
            $table->double('montant_de_votre_loyer')->nullable();
            $table->string('valeur_de_votre_bien_immobilier')->nullable();
            $table->string('rd_immo')->nullable();
            $table->string('restant_du_ce_jour')->nullable();
            $table->string('nom_du_conjoint')->nullable();
            $table->string('date_de_naissance_du_conjoint')->nullable();
            $table->string('profession_du_conjoint')->nullable();
            $table->string('contrat_du_conjoint')->nullable();
            $table->string('contrat_conjoint_depuis_mois')->nullable();
            $table->string('salaire_conjoint')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_prospects');
    }
}
