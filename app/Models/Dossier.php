<?php

namespace App\Models;

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
}
