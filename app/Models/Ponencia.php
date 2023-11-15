<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ponencia extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'evento',
        'fecha_evento',
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
