<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapitre extends Model
{
    protected $fillable = [
        'titre',
        'category_id',
        'cours_id',   // <--- Assurez-vous que cette ligne est présente
    ];

        public function category()
    {
        return $this->belongsTo(Category::class);
    }

public function cours()
{
    return $this->belongsToMany(Cours::class, 'chapitre_cours');
}
}
