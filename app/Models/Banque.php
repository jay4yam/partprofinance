<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banque extends Model
{
    protected $table = 'banques';

    protected $fillable = ['nom', 'logo'];

    /**
     * Relation 1:n vers la table dossier
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dossier()
    {
        return $this->hasMany(Dossier::class, 'banque_id');
    }
}
