<?php

namespace App\Models;

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
        'nom',
        'email',
        'prenom',
        'date_de_naissance',
        'adresse',
        'adresse_2',
        'code_postal',
        'ville',
        'tel_professionnel',
        'situation_familiale',
        'nombre_denfants_a_charge',
        'votre_profession',
        'type_de_votre_contrat',
        'depuis_contrat_mois',
        'votre_salaire',
        'lgmt_depuis_mois',
        'montant_de_votre_loyer',
        'valeur_de_votre_bien_immobilier',
        'rd_immo',
        'restant_du_ce_jour',
        'nom_du_conjoint',
        'date_de_naissance_du_conjoint',
        'profession_du_conjoint',
        'contrat_du_conjoint',
        'contrat_conjoint_depuis_mois',
        'salaire_conjoint'
    ];
}
