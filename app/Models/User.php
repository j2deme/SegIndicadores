<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'apellidos',
        'curp',
        'rfc',
        'telefono',
        'grado_estudios',
        'titulo',
        'cedula',
        'departamento_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Obtiene los registros del usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registros(): HasMany
    {
        return $this->hasMany(Registro::class);
    }

    /**
     * Obtiene el departamento del usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function departamento(): HasOne
    {
        return $this->hasOne(Departamento::class);
    }
}
