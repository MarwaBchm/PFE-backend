<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abbreviation',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function projects()
{
    return $this->hasMany(Project::class);
}
}
