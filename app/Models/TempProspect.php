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
    public $timestamps =  true;

    /**
     * @var array
     */
    protected $fillable = [
        'prospect_source',
        'civilite',
        'nom',
        'nom_jeune_fille',
        'prenom',
        'email',
        'tel_fixe',
        'tel_portable',
        'tel_pro',
        'date_de_naissance',
        'situation_familiale',
        'nombre_denfants_a_charge',
        'nationalite',
        'pays_de_naissance',
        'dpt_de_naissance',
        'ville_de_naissance',
        'secteur_activite',
        'type_de_votre_contrat',
        'votre_profession',
        'depuis_contrat_mois',
        'depuis_contrat_annee',
        'votre_salaire',
        'periodicite_salaire',
        'autre_revenu',
        'civ_du_conjoint',
        'nom_du_conjoint',
        'prenom_du_conjoint',
        'date_de_naissance_du_conjoint',
        'secteur_activite_conjoint',
        'contrat_du_conjoint',
        'profession_du_conjoint',
        'contrat_conjoint_depuis_mois',
        'contrat_conjoint_depuis_annee',
        'salaire_conjoint',
        'periodicite_salaire_conjoint',
        'habitation',
        'lgmt_depuis_mois',
        'lgmt_depuis_annee',
        'adresse',
        'adresse_2',
        'code_postal',
        'ville',
        'mensualite_immo',
        'valeur_de_votre_bien_immobilier',
        'montant_de_votre_loyer',
        'pension_alimentaire',
        'autre_charge',
        'nombre_de_credits_en_cours',
        'total_credit',
        'total_credit_mensualite',
        'restant_du_ce_jour',
        'treso_demande',
        'banque',
        'banque_depuis',
        'notes',
        'user_id'
    ];

    protected $events = [
        'created'  > TempProspectEvents::class,
    ];

    /**
     * Retourne la liste des utilisateurs du mois en cours
     * @param $query
     * @return mixed
     */
    public function scopeCountUserOfTheMonth($query)
    {
        return $query->whereYear('created_at', Carbon::now()->format('Y'))
                     ->whereMonth('created_at', Carbon::now()->format('m'));
    }

    public function scopeCountUserWithDate($query, $month, $year)
    {
        return $query->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);
    }

    /**
     * Retourne la liste des utilisateurs du mois en cours pour l'utilisateur actif
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeCountUserOfTheMonthForSale($query, $userId)
    {
        return $query->whereYear('created_at', Carbon::now()->format('Y'))
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->where('user_id', $userId);
    }

    /**
     * Relation vers la table
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function processProspect()
    {
        return $this->hasOne(ProcessProspect::class, 'temp_prospects_id');
    }

    /**
     * Relation polymorphique vers la table tasks
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }

    public function owner()
    {
        return $this->hasOne(TempProspect::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function dossiers()
    {
        return $this->morphMany(Dossier::class, 'dossierable');
    }
}
