namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'intitule', 'resume', 'techs', 'option_id',
    ];

    protected $casts = [
        'techs' => 'array', // Cast techs to array
    ];

    // Relationships
    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function projectByStudents()
    {
        return $this->hasMany(ProjectByStudent::class);
    }

    public function projectByProfessors()
    {
        return $this->hasMany(ProjectByProfessor::class);
    }

    public function projectByCompanies()
    {
        return $this->hasMany(ProjectByCompany::class);
    }

    public function pfeChoixStudents()
    {
        return $this->hasMany(PFEChoixStudent::class);
    }

    public function defenses()
    {
        return $this->hasMany(Defense::class);
    }
}
