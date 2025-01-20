<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_student_1',
        'id_student_2',
    ];

    public function student1()
    {
        return $this->belongsTo(Student::class, 'id_student_1');
    }

    public function student2()
    {
        return $this->belongsTo(Student::class, 'id_student_2');
    }
    public function projectByStudents()
    {
        return $this->hasMany(ProjectByStudent::class, 'id_grp');
    }
}
