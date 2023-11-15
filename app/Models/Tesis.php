<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tesis extends Model
{
    use HasFactory;
    protected $table = 'tesis';

    protected $fillable = [
        'grado',
        'estatus',
        'user_id',
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
