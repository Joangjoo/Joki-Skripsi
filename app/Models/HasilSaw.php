<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilSaw extends Model
{
    protected $table = 'hasil_saw';

    protected $fillable = [
        'alternative_id',
        'alternative_name',
        'score',
        'rank',
    ];


    public function alternative()
    {
        return $this->belongsTo(CoffeeAlternative::class, 'alternative_id');
    }
}
