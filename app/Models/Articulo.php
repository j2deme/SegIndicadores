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
        'user_id'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registro(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Registro::class, 'registrable');
    }
}
