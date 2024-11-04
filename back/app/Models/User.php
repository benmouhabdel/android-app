<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'registration_key',
        'phone',
        'image_url',
        'annee',       // Ajout de 'annee'
        'classe',      // Ajout de 'classe'
        'filiere'      // Ajout de 'filiere'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin'; // ou toute autre logique pour vérifier si l'utilisateur est admin
    }

    public function hasAnyRole($roles)
    {
        return in_array($this->role, $roles);
    }

    // Relation avec les commentaires
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relation avec les likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
