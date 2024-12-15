<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaDetail extends Model
{
    use HasFactory;

    protected $fillable = ['criteria_id', 'value', 'description'];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
