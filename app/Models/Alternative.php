<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    protected $appends = ['initials'];

    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);

        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return $initials;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'alternative_id', 'id');
    }
}
