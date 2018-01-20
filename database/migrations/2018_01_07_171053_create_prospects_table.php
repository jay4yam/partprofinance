<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('prospects', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('civilite', ['Monsieur', 'Madame']);
            $table->string('nom');
            $table->string('prenom');
            $table->date('dateDeNaissance');
            $table->string('nomEpoux')->nullable();
            $table->string('nationalite');
            $table->string('paysNaissance');
            $table->string('departementNaissance');
            $table->string('VilleDeNaissance');
            $table->enum('situationFamiliale', ['Célibataire', 'Marié(e)', 'Divorcé(e)', 'Vie maritale/Pacs', 'Veuf(ve)']);
            $table->integer('nbEnfantACharge')->default(0);
            $table->string('adresse');
            $table->string('complementAdresse')->nullable();
            $table->string('codePostal');
            $table->string('ville');
            $table->string('numTelFixe')->nullable();
            $table->string('numTelPortable');
            $table->enum('habitation', ['Accèdent à la propriété', 'Propriétaire', 'Locataire', 'Logé par la famille', 'Logé par employeur', 'autre']);
            $table->date('habiteDepuis');
            $table->enum('secteurActivite', ['Secteur privé', 'Secteur public', 'Secteur agricole', 'Artisans-Commerçants', 'Professions libérales', 'Autres']);
            $table->string('profession');
            $table->date('professionDepuis');
            $table->enum('secteurActiviteConjoint', ['Secteur privé', 'Secteur public', 'Secteur agricole', 'Artisans-Commerçants', 'Professions libérales', 'Autres'])->nullable();
            $table->string('professionConjoint')->nullable();
            $table->date('professionDepuisConjoint')->nullable();
            $table->double('revenusNetMensuel');
            $table->double('revenusNetMensuelConjoint')->nullable();
            $table->double('loyer');
            $table->binary('credits')->nullable();
            $table->double('pensionAlimentaire')->nullable();
            $table->string('NomBanque');
            $table->date('BanqueDepuis');
            $table->string('iban')->nullable();
            $table->text('notes')->nullable();
            $table->text('prospect_source')->nullable();
        });

        Schema::table('prospects', function (Blueprint $table){
            $table->integer('user_id')->unsigned();
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
        Schema::table('prospects', function (Blueprint $table){
            $table->dropForeign('prospects_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::dropIfExists('prospects');
    }
}
