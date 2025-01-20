<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Defense extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'salle_id', 'session',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }
}
