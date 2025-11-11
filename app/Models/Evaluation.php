<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'evaluations';
    protected $fillable = ['coffee_alternative_id', 'criteria_id', 'sub_criteria_id'];

    public function coffeeAlternative()
    {
        return $this->belongsTo(CoffeeAlternative::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function subCriteria()
    {
        return $this->belongsTo(SubCriteria::class);
    }
}
