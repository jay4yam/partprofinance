<?php

use Illuminate\Database\Seeder;
use App\Models\TempProspect;

class InsertOldTempProspectData extends Seeder
{
    private function getJsonfile($name)
    {
        //Récupère le nom du fichier importer par l'utilisateur
        $filePath = storage_path('app/public/update_db/'.$name);

        return file_get_contents($filePath);
    }

    private function getResults()
    {
        $file = $this->getJsonfile('temp_prospects.json');

        //Récupère le contenu du fichier
        return json_decode(utf8_encode($file));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $results = $this->getResults();

        foreach ($results as $result)
        {
            $temp = new TempProspect();

            $temp->prospect_source = $result->prospect_source;
            $temp->total_credit = $result->total_credit;
            $temp->total_credit_mensualite = $result->total_credit_mensualite;
            $temp->civilite = $result->civilite;
            $temp->nom = $result->nom;
            $temp->prenom = $result->prenom;
            $temp->date_de_naissance = $result->date_de_naissance;
            $temp->adresse = $result->adresse;
            $temp->adresse_2 = $result->adresse_2;
            $temp->code_postal = $result->code_postal;
            $temp->ville = $result->ville;
            $temp->tel_fixe = $result->tel_fixe;
            $temp->tel_portable = $result->tel_portable;
            $temp->tel_pro = $result->tel_pro;
            $temp->email = $result->email;
            $temp->situation_familiale = $result->situation_familiale;
            $temp->nombre_denfants_a_charge = $result->nombre_denfants_a_charge;
            $temp->votre_profession = $result->votre_profession;
            $temp->type_de_votre_contrat = $result->type_de_votre_contrat;
            $temp->depuis_contrat_mois = $result->depuis_contrat_mois;
            $temp->depuis_contrat_annee = $result->depuis_contrat_annee;
            $temp->votre_salaire = $result->votre_salaire;
            $temp->periodicite_salaire = $result->periodicite_salaire;
            $temp->habitation = $result->habitation;
            $temp->lgmt_depuis_mois = $result->lgmt_depuis_mois;
            $temp->lgmt_depuis_annee = $result->lgmt_depuis_annee;
            $temp->valeur_de_votre_bien_immobilier = $result->valeur_de_votre_bien_immobilier;
            $temp->mensualite_immo = $result->mensualite_immo;
            $temp->restant_du_ce_jour = $result->restant_du_ce_jour;
            $temp->treso_demande = $result->treso_demande;
            $temp->autre_revenu = $result->autre_revenu;
            $temp->autre_charge = $result->autre_charge;
            $temp->civ_du_conjoint = $result->civ_du_conjoint;
            $temp->nom_du_conjoint = $result->nom_du_conjoint;
            $temp->prenom_du_conjoint = $result->prenom_du_conjoint;
            $temp->date_de_naissance_du_conjoint = $result->date_de_naissance_du_conjoint;
            $temp->profession_du_conjoint = $result->profession_du_conjoint;
            $temp->contrat_du_conjoint = $result->contrat_du_conjoint;
            $temp->contrat_conjoint_depuis_mois = $result->contrat_conjoint_depuis_mois;
            $temp->contrat_conjoint_depuis_annee = $result->contrat_conjoint_depuis_annee;
            $temp->salaire_conjoint = $result->salaire_conjoint;
            $temp->periodicite_salaire_conjoint = $result->periodicite_salaire_conjoint;
            $temp->nombre_de_credits_en_cours = $result->nombre_de_credits_en_cours;
            $temp->created_at = $result->created_at;
            $temp->updated_at = $result->updated_at;
            $temp->user_id = 2;

            $temp->save();
        }
    }
}
