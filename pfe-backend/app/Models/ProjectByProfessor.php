<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectByProfessor extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_prof', 'id_coencadrant', 'type',
    ];

    // Relationships
    public function professor()
    {
        return $this->belongsTo(Professor::class, 'id_prof');
    }

    public function coencadrant()
    {
        return $this->belongsTo(Professor::class, 'id_coencadrant');
    }
}
