<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industrial extends Model
{
    use HasFactory;
    protected $table = 'industriales';
    protected $fillable = [
        
        'tipo',
        'clave',
        'fecha_registro',
        'user_id',
        'clasificacion',
        
       
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
