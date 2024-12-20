<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'weight',
        'type'
    ];

    /**
     * Get all of the transactions for the Criteria
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'criteria_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(CriteriaDetail::class, 'criteria_id', 'id');
    }
}
