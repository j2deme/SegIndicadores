<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autoral extends Model
{
    use HasFactory;
    protected $table = 'autorales';
    protected $fillable = [
        'tipo',
        'clave',
        'fecha_registro',
    ];
}
