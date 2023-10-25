<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the Registro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sector that owns the Registro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }
}
 