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
