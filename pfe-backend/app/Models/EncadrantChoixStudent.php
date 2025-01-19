<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncadrantChoixStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'prof_id', 'nombre_de_choix',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class, 'prof_id');
    }
}
