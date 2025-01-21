<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = [
        'id_student_1',
        'id_student_2',
        'invitation_state', // Add the new column
        'groupe_master_average', // Add the new column
    ];

    // Define casts for specific fields
    protected $casts = [
        'invitation_state' => 'string', // Cast invitation_state as a string
        'groupe_master_average' => 'decimal:2', // Cast groupe_master_average as a decimal with 2 decimal places
    ];

    // Define valid invitation states
    public const INVITATION_STATES = [
        'pending',
        'accepted',
        'refused',
    ];

    // Relationship to Student model for student 1
    public function student1()
    {
        return $this->belongsTo(Student::class, 'id_student_1');
    }

    // Relationship to Student model for student 2
    public function student2()
    {
        return $this->belongsTo(Student::class, 'id_student_2');
    }

    // Relationship to ProjectByStudent model
    public function projectByStudents()
    {
        return $this->hasMany(ProjectByStudent::class, 'id_grp');
    }

    // Mutator for invitation_state to ensure only valid values are set
    public function setInvitationStateAttribute($value)
    {
        if (!in_array($value, self::INVITATION_STATES)) {
            throw new \InvalidArgumentException("Invalid invitation state: {$value}");
        }
        $this->attributes['invitation_state'] = $value;
    }
}
