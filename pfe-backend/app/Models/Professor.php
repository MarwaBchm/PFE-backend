<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    // Define constants for the allowed grades
    const GRADE_ASSISTANT_LECTURER_B = 'Assistant Lecturer Class B';
    const GRADE_ASSISTANT_LECTURER_A = 'Assistant Lecturer Class A';
    const GRADE_SENIOR_LECTURER_B = 'Senior Lecturer Class B';
    const GRADE_SENIOR_LECTURER_A = 'Senior Lecturer Class A';
    const GRADE_PROFESSOR = 'Professor';

    // Define an array of allowed grades
    public static $grades = [
        self::GRADE_ASSISTANT_LECTURER_B,
        self::GRADE_ASSISTANT_LECTURER_A,
        self::GRADE_SENIOR_LECTURER_B,
        self::GRADE_SENIOR_LECTURER_A,
        self::GRADE_PROFESSOR,
    ];

    protected $fillable = [
        'firstname',
        'lastname',
        'grade', // Ensure this is fillable
        'recruitment_date',
        'user_id',
    ];

    /**
     * Validation rules for the grade attribute.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'grade' => 'required|in:' . implode(',', self::$grades),
        ];
    }

    /**
     * Get the user associated with the professor.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the master responsibles associated with the professor.
     */
    public function masterResponsibles()
    {
        return $this->hasMany(MasterResponsible::class);
    }

    /**
     * Get the projects by professors associated with the professor.
     */
    public function projectByProfessors()
    {
        return $this->hasMany(ProjectByProfessor::class, 'id_prof');
    }

    /**
     * Get the encadrant choix students associated with the professor.
     */
    public function encadrantChoixStudents()
    {
        return $this->hasMany(EncadrantChoixStudent::class, 'prof_id');
    }

    /**
     * Get the encadrant choix professors associated with the professor.
     */
    public function encadrantChoixProfs()
    {
        return $this->hasMany(EncadrantChoixProf::class, 'prof_id');
    }

    /**
     * Get the jury choix professors associated with the professor.
     */
    public function juryChoixProfs()
    {
        return $this->hasMany(JuryChoixProf::class, 'prof_id');
    }
}
