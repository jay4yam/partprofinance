<?php
/**
 * Created by PhpStorm.
 * User: jayben
 * Date: 20/10/2018
 * Time: 00:26
 */

namespace App\Repositories;


use App\Models\TempProspect;
use Illuminate\Support\Facades\Auth;

class TempProspectRepository
{
    /**
     * @var TempProspect
     */
    protected $tempProspect;

    /**
     * TempProspectRepository constructor.
     * @param TempProspect $tempProspect
     */
    public function __construct(TempProspect $tempProspect)
    {
        $this->tempProspect = $tempProspect;
    }

    /**
     * Retourne un prospect Temportiare via son id
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getById(int $id)
    {
        return $this->tempProspect->with('owner', 'tasks')->findOrFail($id);
    }

    /**
     * Gère l'enregistrement d'un prospect en base
     * @param array $inputs
     */
    public function store(array $inputs)
    {
        $prospect = new TempProspect();

        $this->save($prospect, $inputs);
    }

    /**
     * Methode privée qui gère l'enregistrement d'un prospect
     * @param TempProspect $tempProspect
     * @param array $inputs
     */
    private function save(TempProspect $tempProspect, array $inputs)
    {
        $arrayProfDepuis = explode('-', $inputs['professionDepuis']);
        $arrayProfConjoint = explode('-', $inputs['professionDepuisConjoint']);
        $arrayHabiteDepuis = explode('-', $inputs['habiteDepuis']);

        $tempProspect->prospect_source = $inputs['prospect_source'];
        $tempProspect->civilite = $inputs['civilite'];
        $tempProspect->nom = $inputs['nom'];
        $tempProspect->prenom = $inputs['prenom'];
        $tempProspect->date_de_naissance = $inputs['dateDeNaissance'];
        $tempProspect->adresse = $inputs['adresse'];
        $tempProspect->adresse_2 = $inputs['complementAdresse'];
        $tempProspect->code_postal = $inputs['codePostal'];
        $tempProspect->ville = $inputs['ville'];
        $tempProspect->tel_fixe = $inputs['numTelFixe'];
        $tempProspect->tel_portable = $inputs['numTelPortable'];
        $tempProspect->email = $inputs['email'];
        $tempProspect->situation_familiale = $inputs['situationFamiliale'];
        $tempProspect->nombre_denfants_a_charge = $inputs['nbEnfantACharge'];
        $tempProspect->votre_profession = $inputs['profession'];
        $tempProspect->type_de_votre_contrat = $inputs['type_de_votre_contrat'];
        $tempProspect->depuis_contrat_mois = $arrayProfDepuis[1];
        $tempProspect->depuis_contrat_annee = $arrayProfDepuis[0];
        $tempProspect->votre_salaire = $inputs['revenusNetMensuel'];
        $tempProspect->periodicite_salaire = $inputs['periodicite_salaire'];
        $tempProspect->habitation = $inputs['habitation'];
        $tempProspect->lgmt_depuis_mois = $arrayHabiteDepuis[1];
        $tempProspect->lgmt_depuis_annee = $arrayHabiteDepuis[0];
        $tempProspect->montant_de_votre_loyer = $inputs['loyer'];
        $tempProspect->treso_demande = $inputs['total_credit'];
        $tempProspect->autre_revenu = $inputs['autre_revenu'];
        $tempProspect->autre_charge = $inputs['autre_charge'];
        $tempProspect->civ_du_conjoint = $inputs['civ_du_conjoint'];
        $tempProspect->nom_du_conjoint = $inputs['nom_du_conjoint'];
        $tempProspect->prenom_du_conjoint = $inputs['prenom_du_conjoint'];
        $tempProspect->date_de_naissance_du_conjoint = $inputs['date_de_naissance_du_conjoint'];
        $tempProspect->profession_du_conjoint = $inputs['professionConjoint'];
        $tempProspect->contrat_du_conjoint = $inputs['contrat_du_conjoint'];
        $tempProspect->contrat_conjoint_depuis_mois = $arrayProfConjoint[1];
        $tempProspect->contrat_conjoint_depuis_annee = $arrayProfConjoint[0];
        $tempProspect->salaire_conjoint = $inputs['revenusNetMensuelConjoint'];
        $tempProspect->periodicite_salaire_conjoint = $inputs['periodicite_salaire_conjoint'];
        $tempProspect->nombre_de_credits_en_cours = $inputs['nombre_de_credits_en_cours'];
        $tempProspect->total_credit = $inputs['total_credit'];
        $tempProspect->total_credit_mensualite = $inputs['total_credit_mensualite'];
        $tempProspect->notes = $inputs['notes'];
        $tempProspect->user_id = Auth::user()->id;

        $tempProspect->save();
    }
}