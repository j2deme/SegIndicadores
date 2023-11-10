<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;
    protected $table = 'libros';
    protected $fillable = [
    'tipo_participacion_autor',
    'paginas',
    'isbn',
    'issn',
    'casa_editorial',
    'edicion',
    ];
}
