<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Les attributs pouvant être remplis en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'matricule',
        'name',
        'prename',
        'email',
        'image',
        'password',
        'role',
    ];

    /**
     * Les attributs cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relation avec les projets (un utilisateur peut être chef de plusieurs projets).
     */
    public function projets()
    {
        // return $this->hasMany(Projet::class, 'user_id');
        return $this->hasMany(Projet::class);

    }

    /**
     * Vérifie si l'utilisateur est un admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est un employé.
     */
    public function isEmployee()
    {
        return $this->role === 'employee';
    }
}
