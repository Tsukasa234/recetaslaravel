<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    //campos que se agregaran
    protected $fillable = [
        'titulo',
        'preparacion',
        'ingredientes',
        'imagen',
        'categoria_id'
    ];

    //Obtiene la categoria via FK
    public function categoria()
    {
        return $this->belongsTo(CategoriaReceta::class);
    }

    //Obtiene el usuario via FK
    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //Recetas a las que el usuario a dado me gusta
    public function likes()
    {
        return $this->belongsToMany(Receta::class, 'likes_receta');
    }
}
