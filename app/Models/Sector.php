<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $table = 'sectores';

    protected $fillable = [
        'nombre', 
        
    ];

    public function subsector()
    {
        return $this->hasMany(Subsector::class);
    }
    
}
