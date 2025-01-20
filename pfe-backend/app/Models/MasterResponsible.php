<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterResponsible extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'professor_id', // Foreign key to the professors table
        'major_id',     // Foreign key to the majors table
    ];

    /**
     * Get the professor associated with the master responsible.
     */
    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    /**
     * Get the major associated with the master responsible.
     */
    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
