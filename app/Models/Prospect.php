<?php

namespace App\Models;


use Carbon\Carbon;
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
        'mandat_status',
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

    public function scopeMonthly($query)
    {
        return $query->whereMonth('created_at', Carbon::now()->format('m'));
    }

    public function scopeSalers($query, $userId)
    {
        return $query->where('user_id', '=',$userId);
    }

    public function scopeCountUserWithDate($query, $month, $year)
    {
        return $query->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year);
    }

    /**
     * Relation 1/1 vers la table user pour lier à un commercial à un prospect
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function dossiers()
    {
        return $this->morphMany(Dossier::class, 'dossierable');
    }

    /**
     * Relation polymorphyque avec la table tasks
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }
}
