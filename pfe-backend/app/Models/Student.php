<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'option_id',
        'groupe_id',
        'master_average',
        'ranking',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }
    public function pfeChoixStudents()
{
    return $this->hasMany(PFEChoixStudent::class, 'student_id');
}

public function encadrantChoixStudents()
{
    return $this->hasMany(EncadrantChoixStudent::class, 'student_id');
}
}
