namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectByStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_grp', 'materials', 'type',
    ];

    protected $casts = [
        'materials' => 'array', // Cast materials to array
    ];

    // Relationships
    public function groupe()
    {
        return $this->belongsTo(Groupe::class, 'id_grp');
    }
}
