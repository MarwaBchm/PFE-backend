<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuryChoixProf extends Model
{
    use HasFactory;

    protected $fillable = [
        'prof_id', 'defense_id', 'nombre_de_choix',
    ];

    // Relationships
    public function professor()
    {
        return $this->belongsTo(Professor::class, 'prof_id');
    }

    public function defense()
    {
        return $this->belongsTo(Defense::class, 'defense_id');
    }
}
