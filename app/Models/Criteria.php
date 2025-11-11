<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $table = 'criterias';
    protected $fillable = ['code', 'name', 'weight', 'type'];

    public function subCriteria()
    {
        return $this->hasMany(SubCriteria::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
