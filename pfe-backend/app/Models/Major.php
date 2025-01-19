<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'abbreviation',
        'denomination',
        'responsible_id',
    ];

    public function responsible()
    {
        return $this->belongsTo(Professor::class, 'responsible_id');
    }

    public function masterResponsibles()
    {
        return $this->hasOne(MasterResponsible::class);
    }
}
