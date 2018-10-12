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

    public $timestamps = true;

    protected $fillable = [
        'civilite',
        'nom',
        'email',
        'nomjeunefille',
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
        'prospect_id',
        'user_id',
        'prospect_source'
    ];

    protected $dates = [
        'dateDeNaissance',
        'habiteDepuis',
        'professionDepuis',
        'professionDepuisConjoint',
        'BanqueDepuis'
    ];

    /**
     * Retourne les prospects n'appartenant qu'à l'utilisateur en cours
     * @param $query
     * @return mixed
     */
    public function scopeOwner($query)
    {
        return $query->where('user_id', '=', \Auth::user()->id);
    }

    /**
     * Relation 1/1 vers la table user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation &:n vers la table dossiers
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dossier()
    {
        return $this->hasMany(Dossier::class, 'prospect_id');
    }

    /**
     * Relation 1:n vers la table task
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'prospect_id');
    }
}
