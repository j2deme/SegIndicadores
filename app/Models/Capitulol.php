<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capitulol extends Model
{
    use HasFactory;
    protected $table = 'capitulols';
    protected $fillable = [
        'libro',
        'pagina_inicio',
        'pagina_fin',
        'isbn',
        'issn',
        'casa_editorial',
        'edicion',

    ];
}
