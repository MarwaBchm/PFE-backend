<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'grade',
        'recruitment_date',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function masterResponsibles()
    {
        return $this->hasMany(MasterResponsible::class);
    }
    public function projectByProfessors()
{
    return $this->hasMany(ProjectByProfessor::class, 'id_prof');
}

public function encadrantChoixStudents()
{
    return $this->hasMany(EncadrantChoixStudent::class, 'prof_id');
}

public function encadrantChoixProfs()
{
    return $this->hasMany(EncadrantChoixProf::class, 'prof_id');
}

public function juryChoixProfs()
{
    return $this->hasMany(JuryChoixProf::class, 'prof_id');
}
}
