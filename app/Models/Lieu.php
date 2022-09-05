<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lieu extends Model
{
    use HasFactory;

    public function dico()
    {
        return $this->belongsTo(Dictionnaire::class, "dictionnaire");
    }

    public function images(){
        return $this->hasMany(Image::class, 'lieu');
    }
}
