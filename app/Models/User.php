<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'url',
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
    ];

    //evento que se ejecuta cuando un usuario es creado
    protected static function booted()
    {
        parent::booted();

        //asignar perfil una vez se haya creado un usuario nuevo
        static::created(function($user){
            $user->perfil()->create();
        });
    }

    //Relacion de 1:n de usuarios a receta
    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }

    //Relacion de 1:1 de usuarios y perfil
    public function perfil()
    {
        return $this->hasOne(Perfil::class);
    }

    //Relacion de Likes que una receta recibee
    /**
     * The likes that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likesMe()
    {
        return $this->belongsToMany(User::class, 'likes_receta');
    }
}
