<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Departamento extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'jefe_id',
    ];

    /**
     * Obtiene el jefe del departamento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jefe(): BelongsTo
    {
        return $this->belongsTo(User::class, 'jefe_id', 'id')->where('es_admin', false);
    }
}
