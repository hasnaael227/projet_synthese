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
public function cours()
{
    return $this->hasMany(Cours::class, 'category_id');
}

public function etudiants()
{
    return $this->belongsToMany(Etudiant::class, 'category_etudiant');
}
// Categorie.php
public function paiements() {
    return $this->hasMany(Paiement::class);
}
}
