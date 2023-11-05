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
        
       
    ];
}
