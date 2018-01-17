<?php

namespace App\Models;

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
        'name', 'email', 'password', 'role', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeGuest($query)
    {
        return $query->where('role', 'guest');
    }

    /**
     * Relation 1/1 vers la table prospect
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function prospect()
    {
        return $this->hasOne(Prospect::class, 'user_id');
    }

    public function dossier()
    {
        return $this->hasMany(Banque::class, 'user_id');
    }
}
