<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    protected $table = 'dossiers';

    public $iban = 0;

    protected $fillable = [
        'signature',
        'objet_du_pret',
        'duree_du_pret',
        'montant_demande',
        'montant_final',
        'taux_commission',
        'montant_commission_partpro',
        'apporteur',
        'taux_commission',
        'status',
        'user_id',
        'banque_id',
        'num_dossier_banque'
    ];

    /**
     * Retourne les dossiers du mois
     * @param $query
     * @return mixed
     */
    public function scopeDossierOfTheMonth($query)
    {
        return $query->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'));
    }

    /**
     * Retourne les dossiers du mois refusés
     * @param $query
     * @return mixed
     */
    public function scopeDossierRefusedOfTheMonth($query)
    {
        return $query->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'))
            ->where('status', '=', 'Refusé');
    }

    /**
     * Retourne les dossiers du mois acceptés
     * @param $query
     * @return mixed
     */
    public function scopeDossierAcceptedOfTheMonth($query)
    {
        return $query->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('updated_at', Carbon::now()->format('m'))
            ->where('status', '=', 'Accepté');
    }

    /**
     * Retourne les dossiers du montant dont le status est payé
     * @param $query
     * @return mixed
     */
    public function scopeDossierPayeeOfTheMonth($query)
    {
        return $query->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('updated_at', Carbon::now()->format('m'))
            ->where('status', '=', 'Payé');
    }


    /**
     * Relation 1:n avec la table User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation 1:n avec la table banque
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function banque()
    {
        return $this->belongsTo(Banque::class, 'banque_id');
    }


    /**
     * Relation entre les Prospects (qui sont des users) et les dossiers
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prospect()
    {
        return $this->belongsTo(Prospect::class, 'user_id');
    }
}
