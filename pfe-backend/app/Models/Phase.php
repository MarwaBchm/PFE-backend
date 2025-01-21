<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'starting_date',
        'ending_date',
        'for_professor',
        'for_student',
        'for_responsible',
        'for_company',
    ];
}
