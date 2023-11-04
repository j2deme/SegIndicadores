<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prototipo extends Model
{
    use HasFactory;
    

    protected $fillable = [
        
        'nombre_instituto',
        'tipo',
        'objetivo',
        'caracteristicas',
       
    ];
}
