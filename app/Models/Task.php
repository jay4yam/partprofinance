<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table ='tasks';

    protected $dates = ['created_at', 'taskdate', 'updated_at'];

    protected $fillable = [ 'task_creator_user_id', 'taskdate', 'taskcontent', 'status', 'level', 'created_at', 'updated_at', 'user_id'];

    /**
     * Inverse de la relation 1:n vers la table user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
