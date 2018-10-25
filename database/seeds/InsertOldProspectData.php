<?php

use Illuminate\Database\Seeder;
use App\Models\Prospect;

class InsertOldProspectData extends Seeder
{
    private function getJsonfile($name)
    {
        //Récupère le nom du fichier importer par l'utilisateur
        $filePath = storage_path('app/public/update_db/'.$name);

        return file_get_contents($filePath);
    }

    private function getResults()
    {
        $file = $this->getJsonfile('prospects.json');

        //Récupère le contenu du fichier
        return json_decode(utf8_encode($file));
    }

    /**
     * @param int $old_user_id
     * @return string
     */
    private function replaceOldEmail(int $old_user_id)
    {
        //Récupère le nom du fichier importer par l'utilisateur
        $filePath = storage_path('app/public/update_db/users.json');

        $file = file_get_contents($filePath);

        $results = json_decode(utf8_encode($file));

        foreach ($results as $result)
        {
            if($result->id == $old_user_id) return $result->email;
        }
    }

    private function replaceOldCreated_at(int $old_user_id)
    {
        //Récupère le nom du fichier importer par l'utilisateur
        $filePath = storage_path('app/public/update_db/users.json');

        $file = file_get_contents($filePath);

        $results = json_decode(utf8_encode($file));

        foreach ($results as $result)
        {
            if($result->id == $old_user_id) return $result->created_at;
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
            $prospect = new Prospect();

            $prospect->civilite = $result->civilite;
            $prospect->nom = $result->nom;
            $prospect->email = $this->replaceOldEmail($result->user_id);
            $prospect->nomjeunefille = $result->nomjeunefille;
            $prospect->prenom = $result->prenom;
            $prospect->dateDeNaissance = $result->dateDeNaissance;
            $prospect->nomEpoux = $result->nomEpoux;
            $prospect->nationalite = $result->nationalite;
            $prospect->paysNaissance = $result->paysNaissance;
            $prospect->departementNaissance = $result->departementNaissance;
            $prospect->VilleDeNaissance = $result->VilleDeNaissance;
            $prospect->situationFamiliale = $result->situationFamiliale;
            $prospect->nbEnfantACharge = $result->nbEnfantACharge;
            $prospect->adresse = $result->adresse;
            $prospect->complementAdresse = $result->complementAdresse;
            $prospect->codePostal = $result->codePostal;
            $prospect->ville = $result->ville;
            $prospect->numTelFixe = $result->numTelFixe;
            $prospect->numTelPortable = $result->numTelPortable;
            $prospect->habitation = $result->habitation;
            $prospect->habiteDepuis = $result->habiteDepuis;
            $prospect->secteurActivite = $result->secteurActivite;
            $prospect->profession = $result->profession;
            $prospect->professionDepuis = $result->professionDepuis;
            $prospect->secteurActiviteConjoint = $result->secteurActiviteConjoint;
            $prospect->professionConjoint = $result->professionConjoint;
            $prospect->professionDepuisConjoint = $result->professionDepuisConjoint;
            $prospect->revenusNetMensuel = $result->revenusNetMensuel;
            $prospect->revenusNetMensuelConjoint = $result->revenusNetMensuelConjoint;
            $prospect->loyer = $result->loyer;
            $prospect->credits = $result->credits;
            $prospect->pensionAlimentaire = $result->pensionAlimentaire;
            $prospect->NomBanque = $result->NomBanque;
            $prospect->BanqueDepuis = $result->BanqueDepuis;
            $prospect->iban = $result->iban;
            $prospect->notes = $result->notes;
            $prospect->prospect_source = $result->prospect_source;
            $prospect->user_id = 2;
            $prospect->mandat_status = $result->mandat_status;
            $prospect->created_at = $this->replaceOldCreated_at($result->user_id);

            $prospect->save();
        }
    }

}
