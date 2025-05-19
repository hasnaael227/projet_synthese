<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $fillable = [
        'nom', 'prenom', 'numTel', 'email', 'password',
    ];

    protected $hidden = [
        'password',
    ];
    public function progressions() {
    return $this->hasMany(Progression::class, 'etudiant_id');
}
}
