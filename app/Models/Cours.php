<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'type_pdf',
        'type_video',
        'category_id',
        'formateur_id',
    ];

    // Relation avec la catégorie
    public function categorie()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relation avec le formateur (utilisateur)
    public function formateur()
    {
        return $this->belongsTo(User::class, 'formateur_id');
    }
    public function chapitres()
    {
        return $this->belongsToMany(Chapitre::class, 'chapitre_cours');
    }
    public function category()
{
    return $this->belongsTo(Category::class);
}

}
