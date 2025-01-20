<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncadrantChoixProf extends Model
{
    use HasFactory;

    protected $fillable = [
        'prof_id', 'project_id', 'nombre_de_choix',
    ];

    // Relationships
    public function professor()
    {
        return $this->belongsTo(Professor::class, 'prof_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
