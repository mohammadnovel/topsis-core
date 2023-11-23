<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'alternative_id',
        'criteria_id',
        'value'
    ];

    /**
     * Get the Criteria that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function criterias()
    {
        return $this->belongsTo(Criteria::class, 'criteria_id', 'id');
    }

    public function alternatives()
    {
        return $this->belongsTo(Alternative::class, 'alternative_id', 'id');
    }
}
