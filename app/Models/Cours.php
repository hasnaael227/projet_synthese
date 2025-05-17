<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    protected $fillable = [
        'titre', 'contenu', 'image', 'type_pdf', 'type_video',
        'category_id', 'chapitre_id', 'formateur_id'
    ];

    public function categorie()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function chapitre()
    {
        return $this->belongsTo(Chapitre::class, 'chapitre_id');
    }

    public function formateur()
    {
        return $this->belongsTo(User::class, 'formateur_id');
    }
}
