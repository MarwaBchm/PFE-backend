<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectByCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_company',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class, 'id_company');
    }
}
