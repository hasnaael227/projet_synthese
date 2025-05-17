<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Champs autorisés pour l'assignation en masse
    protected $fillable = ['name', 'description', 'image', 'prix'];

    public function chapitres()
{
    return $this->hasMany(Chapitre::class);
}
}
