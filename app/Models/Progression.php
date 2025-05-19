<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progression extends Model
{
    use HasFactory;

public function etudiant() {
    return $this->belongsTo(Etudiant::class);
}

public function cours() {
    return $this->belongsTo(Cours::class);
}
}
