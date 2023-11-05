<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;
    protected $fillable = [
        'revista',
        'estatus',
        'tipo',
        'volumen',
        'indice',
        'url',
        'pagina_inicio',
        'pagina_fin',
        'isbn',
        'issn',
        'casa_editorial',


    ];
}
