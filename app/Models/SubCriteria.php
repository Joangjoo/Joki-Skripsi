<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCriteria extends Model
{
    protected $table = 'sub_criterias';
    protected $fillable = ['criteria_id', 'name', 'value'];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
