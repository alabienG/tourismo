<?php

namespace App\Models;

use App\utils\Constantes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dictionnaire extends Model
{
    use HasFactory;

    public function pere()
    {
        return $this->belongsTo(Dictionnaire::class, 'parent');
    }

    public function getType()
    {
        if ($this->pays) return Constantes::$pays;
        else if ($this->region) return Constantes::$region;
        else return Constantes::$ville;
    }
}
