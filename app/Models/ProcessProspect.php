<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessProspect extends Model
{
    protected $table ='process_prospects';

    protected $fillable = [
        'status',
        'relance_status',
        'relance_j1',
        'relance_j4',
        'notes',
        'temp_prospects_id'
        ];

    protected $dates = ['relance_j1', 'relance_j4'];

    /**
     * Relation vers la table tempProspect
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tempProspect()
    {
        return $this->belongsTo(TempProspect::class, 'temp_prospects_id', 'id');
    }
}
