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
            $table->string('total_credit')->nullable();
            $table->string('total_credit_mensualite')->nullable();
            $table->string('civilite')->nullable();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('date_de_naissance')->nullable();
            $table->string('adresse')->nullable();
            $table->string('adresse_2')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('ville')->nullable();
            $table->string('tel_fixe')->nullable();
            $table->string('tel_portable')->nullable();
            $table->string('tel_pro')->nullable();
            $table->string('email');
            $table->string('situation_familiale')->nullable();
            $table->string('nombre_denfants_a_charge')->nullable();
            $table->string('votre_profession')->nullable();
            $table->string('type_de_votre_contrat')->nullable();
            $table->integer('depuis_contrat_mois')->nullable();
            $table->integer('depuis_contrat_annee')->nullable();
            $table->double('votre_salaire')->nullable();
            $table->integer('periodicite_salaire')->nullable();
            $table->string('habitation')->nullable();
            $table->integer('lgmt_depuis_mois')->nullable();
            $table->integer('lgmt_depuis_annee')->nullable();
            $table->double('montant_de_votre_loyer')->nullable();
            $table->string('valeur_de_votre_bien_immobilier')->nullable();
            $table->string('mensualite_immo')->nullable();
            $table->string('restant_du_ce_jour')->nullable();
            $table->string('treso_demande')->nullable();
            $table->string('autre_revenu')->nullable();
            $table->string('autre_charge')->nullable();
            $table->string('civ_du_conjoint')->nullable();
            $table->string('nom_du_conjoint')->nullable();
            $table->string('prenom_du_conjoint')->nullable();
            $table->string('date_de_naissance_du_conjoint')->nullable();
            $table->string('profession_du_conjoint')->nullable();
            $table->string('contrat_du_conjoint')->nullable();
            $table->integer('contrat_conjoint_depuis_mois')->nullable();
            $table->integer('contrat_conjoint_depuis_annee')->nullable();
            $table->string('salaire_conjoint')->nullable();
            $table->string('periodicite_salaire_conjoint')->nullable();
            $table->string('nombre_de_credits_en_cours')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::table('temp_prospects', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->unsigned();
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
        Schema::table('temp_prospects', function (Blueprint $table){
            $table->dropForeign('temp_prospects_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::dropIfExists('temp_prospects');
    }
}
