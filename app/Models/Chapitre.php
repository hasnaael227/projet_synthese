<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapitre extends Model
{
    protected $fillable = ['titre', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
