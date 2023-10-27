<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsector extends Model
{
    use HasFactory;

    protected $table = 'subsectores';

    protected $fillable = [
        'nombre',
        'sector_id',
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    /**
     * Get all of the registro for the Subsector
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registros(): HasMany
    {
        return $this->hasMany(Registro::class);
    }
}
