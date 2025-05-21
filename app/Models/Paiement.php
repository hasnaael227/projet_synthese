<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
    'category_id',
    'etudiant_id',
    'cin',
    'numero_carte',
    'date_expiration',
    'code_securite',
];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
