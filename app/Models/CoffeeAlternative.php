<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoffeeAlternative extends Model
{
    protected $table = 'coffee_alternatives';
    protected $fillable = ['name', 'description'];

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
