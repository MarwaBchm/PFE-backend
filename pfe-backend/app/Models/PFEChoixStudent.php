<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PFEChoixStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'project_id', 'nombre_de_choix',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
