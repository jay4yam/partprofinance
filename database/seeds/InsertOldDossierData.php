<?php

use Illuminate\Database\Seeder;
use App\Models\Dossier;

class InsertOldDossierData extends Seeder
{
    private function getJsonfile($name)
    {
        //Récupère le nom du fichier importer par l'utilisateur
        $filePath = storage_path('app/public/update_db/'.$name);

        return file_get_contents($filePath);
    }

    private function getResults()
    {
        $file = $this->getJsonfile('dossiers.json');

        //Récupère le contenu du fichier
        return json_decode(utf8_encode($file));
    }

    private function replaceProspectId($oldUserId)
    {
        //Récupère le nom du fichier importer par l'utilisateur
        $filePath = storage_path('app/public/update_db/users.json');

        $file = file_get_contents($filePath);

        $results = json_decode(utf8_encode($file));

        foreach ($results as $result)
        {
            if($result->id == $oldUserId){

                $prospect = \App\Models\Prospect::where('email', '=', $result->email)->get(['id'])->first();

                return $prospect->id;
            }
        }
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
            $dossier = new Dossier();

            $dossier->signature = $result->signature;
            $dossier->objet_du_pret = $result->objet_du_pret;
            $dossier->duree_du_pret = $result->duree_du_pret;
            $dossier->montant_demande = $result->montant_demande;
            $dossier->montant_final = $result->montant_final;
            $dossier->taux_commission = $result->taux_commission;
            $dossier->montant_commission_partpro = $result->montant_commission_partpro;
            $dossier->apporteur = $result->apporteur;
            $dossier->status = $result->status;
            $dossier->num_dossier_banque = $result->num_dossier_banque;
            $dossier->dossierable_id = $this->replaceProspectId( $result->user_id);
            $dossier->dossierable_type = 'App\Models\Prospect';
            $dossier->created_at = $result->created_at;
            $dossier->updated_at = $result->updated_at;
            $dossier->user_id = 2;
            $dossier->banque_id = $result->banque_id;

            $dossier->save();

            $prospect = \App\Models\Prospect::findOrFail( $this->replaceProspectId( $result->user_id) );

            $prospect->dossiers()->save($dossier);
        }
    }
}
