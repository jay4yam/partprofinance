<?php

namespace App\Models;

use App\Events\DossierCreatedEvent;
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
        return $query->whereYear('created_at', Carbon::now()->format('Y'))
                     ->whereMonth('created_at', Carbon::now()->format('m'));
    }

    /**
     * Retourne les dossiers du mois
     * @param $query
     * @return mixed
     */
    public function scopeDossierForMonthAndYear($query, $month, $year)
    {
        return $query->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);
    }

    /**
 * Retourne les dossiers du mois acceptés
 * @param $query
 * @return mixed
 */
    public function scopeDossierAcceptedOfTheMonth($query)
    {
        return $query->whereYear('created_at', Carbon::now()->format('Y'))
            ->whereMonth('updated_at', Carbon::now()->format('m'))
            ->where('status', '=', 'Accepté')
            ->orWhere('status', '=', 'Payé');
    }

    /**
     * Retourne les dossiers acceptés pour les dates passés en paramètres
     * @param $query
     * @param $month
     * @param $year
     * @return mixed
     */
    public function scopeDossierAcceptedForTheMonthAndYear($query, $month, $year)
    {
        return $query->whereYear('created_at', $year)
            ->whereMonth('updated_at', $month)
            ->where('status', '=', 'Accepté');
    }

    /**
     * Retourne les dossiers du mois acceptés
     * @param $query
     * @return mixed
     */
    public function scopeDossierPaidOfTheMonth($query)
    {
        return $query->whereYear('created_at', Carbon::now()->format('Y'))
            ->whereMonth('updated_at', Carbon::now()->format('m'))
            ->where('status', '=', 'Payé');
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
     * Retourne les dossiers refusés du mois / annee passé en parame
     * @param $query
     * @param $month
     * @param $year
     * @return mixed
     */
    public function scopeDossierRefusedForMonthAndYear($query, $month, $year)
    {
        return $query->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status', '=', 'Refusé');
    }

    /**
     * Retourne les dossiers du montant dont le status est payé
     * @param $query
     * @return mixed
     */
    public function scopeDossierPayeeOfTheMonth($query)
    {
        return $query->whereYear('created_at', Carbon::now()->format('Y'))
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->where('status', '=', 'Payé');
    }

    public function scopeDossierPayeeForMonthAndYear($query, $month, $year)
    {
        return $query->whereYear('created_at', $year)->whereMonth('created_at', $month)
            ->where('status', '=', 'Payé');
    }

    /**
     * Retourne les dossiers de l'utilisateur en cours
     * @param $query
     * @return mixed
     */
    public function scopeOwner($query)
    {
        return $query->where('user_id', \Auth::user()->id);
    }

    /**
     * Retourne les dossiers du mois pour un commercial
     * @param int $userId
     * @param $query
     * @return mixed
     */
    public function scopeDossierOfTheMonthForSale($query, $userId)
    {
        return $query->where('user_id', '=', $userId)
                    ->whereYear('created_at', Carbon::now()->format('Y'))
                    ->whereMonth('updated_at', Carbon::now()->format('m'));
    }

    /**
     * Retourne les dossiers du mois refusés du commercial
     * @param $query
     * @return mixed
     */
    public function scopeDossierRefusedOfTheMonthForSale($query, int $userId)
    {
        return $query->where('user_id', '=', $userId)
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->whereMonth('updated_at', Carbon::now()->format('m'))
            ->where('status', '=', 'Refusé');
    }

    /**
     * Retourne les dossiers du mois acceptés
     * @param $query
     * @return mixed
     */
    public function scopeDossierAcceptedOfTheMonthForSale($query, int $userId)
    {
        return $query->whereYear('created_at', Carbon::now()->format('Y'))
                    ->whereMonth('updated_at', Carbon::now()->format('m'))
                    ->where('status', '=', 'Accepté')
                    ->where('user_id', '=', $userId);
    }

    /**
     * Retourne les dossiers du mois acceptés
     * @param $query
     * @param  int $userId
     * @return mixed
     */
    public function scopeDossierPaidOfTheMonthForSale($query, int $userId)
    {
        return $query->where('user_id', '=', $userId)
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->whereMonth('updated_at', Carbon::now()->format('m'))
            ->where('status', '=', 'Payé');
    }


    /**
     * RELATION ENTRE MODEL
     **/

    /**
     * Relation 1:n avec la table banque
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function banque()
    {
        return $this->belongsTo(Banque::class, 'banque_id');
    }

    /**
     * Relation 1:n avec la table banque
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation polymorphic
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function dossierable()
    {
        return $this->morphTo();
    }

    public function prospect(){
        return $this->belongsTo(Prospect::class, 'dossierable_id');
    }

}
