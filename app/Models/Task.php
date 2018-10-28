<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table ='tasks';

    protected $dates = ['created_at', 'taskdate', 'updated_at'];

    protected $fillable = [ 'taskdate', 'taskcontent', 'level', 'status', 'taskable_id', 'taskable_type', 'created_at', 'updated_at', 'user_id'];

    /**
     * Inverse de la relation 1:n vers la table user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * Get all of the owning task models.
     */
    public function taskable()
    {
        return $this->morphTo();
    }
}

