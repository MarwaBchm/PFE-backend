<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name', // Name of the major
        'abbreviation', // Abbreviation of the major
    ];

    /**
     * Get the master responsibles for the major.
     */
    public function masterResponsibles()
    {
        return $this->hasMany(MasterResponsible::class);
    }
}
