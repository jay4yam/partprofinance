<?php

namespace App\Models;

use App\Events\TempProspectEvents;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TempProspect extends Model
{
    /**
     * @var string
     */
    protected $table = 'temp_prospects';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = [
        'prospect_source',
        'total_credit',
        'total_credit_mensualite',
        'civilite',
        'nom',
        'prenom',
        'date_de_naissance',
        'adresse',
        'adresse_2',
        'code_postal',
        'ville',
        'tel_fixe',
        'tel_portable',
        'tel_pro',
        'email',
        'situation_familiale',
        'nombre_denfants_a_charge',
        'votre_profession',
        'type_de_votre_contrat',
        'depuis_contrat_mois',
        'depuis_contrat_annee',
        'votre_salaire',
        'periodicite_salaire',
        'habitation',
        'lgmt_depuis_mois',
        'lgmt_depuis_annee',
        'montant_de_votre_loyer',
        'valeur_de_votre_bien_immobilier',
        'mensualite_immo',
        'restant_du_ce_jour',
        'treso_demande',
        'autre_revenu',
        'autre_charge',
        'civ_du_conjoint',
        'nom_du_conjoint',
        'prenom_du_conjoint',
        'date_de_naissance_du_conjoint',
        'profession_du_conjoint',
        'contrat_du_conjoint',
        'contrat_conjoint_depuis_mois',
        'contrat_conjoint_depuis_annee',
        'salaire_conjoint',
        'periodicite_salaire_conjoint',
        'nombre_de_credits_en_cours'
    ];

    protected $events = [
        'created' => TempProspectEvents::class,
    ];

    /**
     * Retourne la liste des utilisateurs du mois en cours
     * @param $query
     * @return mixed
     */
    public function scopeCountUserOfTheMonth($query)
    {
        return $query->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'));
    }

    /**
     * Relation vers la table
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function processProspect()
    {
        return $this->hasOne(ProcessProspect::class, 'temp_prospects_id');
    }
}
