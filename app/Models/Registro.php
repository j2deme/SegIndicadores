<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'proposito',
        'autores',
        'posicion_autor',
        'descripcion',
        'sector_id',
        'subsector_id',
        'area_prioritaria_pais',
        'area_conocimiento',
        'fecha_publicacion',
        'pais_publicacion',
        'evidencia',
        'registrable_id',
        'registrable_type',
    ];

    protected $casts = [
        'evidencia' => 'array',
    ];

    /**
     * Get the user that owns the Registro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sector that owns the Registro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function subsector()
    {
        return $this->belongsTo(Subsector::class);
    }

    public function registrable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
