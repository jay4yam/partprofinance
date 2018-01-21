<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Prospect
 *
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 */
class Prospect extends Model
{
    protected $table = 'prospects';

    public $timestamps = false;

    protected $fillable = [
        'civilite',
        'nom',
        'prenom',
        'dateDeNaissance',
        'nomEpoux',
        'nationalite',
        'paysNaissance',
        'departementNaissance',
        'VilleDeNaissance',
        'situationFamiliale',
        'nbEnfantACharge',
        'adresse',
        'complementAdresse',
        'codePostal',
        'ville',
        'numTelFixe',
        'numTelPortable',
        'habitation',
        'habiteDepuis',
        'secteurActivite',
        'profession',
        'professionDepuis',
        'secteurActiviteConjoint',
        'professionConjoint',
        'professionDepuisConjoint',
        'revenusNetMensuel',
        'revenusNetMensuelConjoint',
        'loyer',
        'credits',
        'pensionAlimentaire',
        'NomBanque',
        'BanqueDepuis',
        'iban',
        'notes',
        'user_id',
        'prospect_source'
    ];


    /**
     * Relation 1/1 vers la table user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dossier()
    {
        return $this->hasMany(Dossier::class, 'user_id');
    }
}
