<?php

namespace App\Models;

use App\Events\UserCreateEvent;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Models\Prospect $prospect
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User guest()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'avatar', 'commission_rate'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * scopeMethode Pour n'afficher que les utilisateurs qui ne sont ni admin, ni staff
     * @param $query
     * @return mixed
     */
    public function scopeGuest($query)
    {
        return $query->where('role', 'guest');
    }

    /**
     * scopeStaff, retourne uniquement les utilisateurs dont le rôle est staff
     * @param $query
     * @return mixed
     */
    public function scopeStaff($query)
    {
        return $query->where('role', 'staff');
    }

    /**
     * Retourne la liste des utilisateurs du mois en cours
     * @param $query
     * @return mixed
     */
    public function scopeCountUserOfTheMonth($query)
    {
        return $query->guest()->whereYear('created_at', Carbon::now()->format('Y'))
            ->whereMonth('created_at', Carbon::now()->format('m'));
    }



    /**
     * Relation 1/1 vers la table prospect
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prospects()
    {
        return $this->hasMany(Prospect::class, 'user_id');
    }

    /**
     * Relation 1:n vers la table task
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    /**
     * Relation 1:n vers la table task
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dossiers()
    {
        return $this->hasMany(Dossier::class, 'user_id');
    }

    /**
     * Relation 1:n vers la table tempProspect
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tempProspects()
    {
        return $this->hasMany(TempProspect::class, 'user_id');
    }
}
