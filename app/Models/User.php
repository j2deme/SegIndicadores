<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, HasName, HasAvatar
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
        'departamento_id',
        'es_admin'
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
        'es_admin' => 'boolean',
        'es_jefe' => 'boolean'
    ];

    protected $appends = ['nombre_completo', 'es_jefe', 'avatar'];

    public function canAccessPanel(Panel $panel): bool
    {
        return (str_ends_with($this->email, '@tecvalles.mx'));
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $name = str($this->name . ' ' . $this->apellidos)
            ->trim()
            ->explode(' ')
            ->map(fn(string $segment): string => filled($segment) ? mb_substr($segment, 0, 1) : '')
            ->join(' ');

            return "https://api.dicebear.com/9.x/initials/svg?seed=" . urlencode($name);
    }

    public function getFilamentName(): string
    {
        return "{$this->name} {$this->apellidos}";
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->name} {$this->apellidos}";
    }

    public function getEsJefeAttribute(): bool
    {
        return Departamento::where('jefe_id', $this->id)->exists();
    }

    public function getAvatarAttribute(): string
    {
        return $this->getFilamentAvatarUrl();
    }

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
     * Obtiene el departamento de adscripción del usuario.
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    /**
     * Obtiene la jefatura del usuario.
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function jefatura(): HasOne
    {
        return $this->hasOne(Departamento::class, 'jefe_id', 'id');
    }
}
