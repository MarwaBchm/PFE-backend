<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'user_id',
    ];

    /**
     * Get the user that owns the professor.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function masterResponsibles()
{
    return $this->hasMany(MasterResponsible::class);
}

}
