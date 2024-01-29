<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Walkin extends Model
{
    use  HasFactory;
    protected $appends = ['is_superadmin', 'is_client', 'is_agency','is_admissionteam','is_frontoffice', ];

    public $table = 'walkinform';

    public static $searchable = [
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
<<<<<<< HEAD
        'source_id'
=======
        'source_id',
        'project_id',
        'campaign_id'
       

>>>>>>> 1434718 (live)
    ];
    public function leads()
{
    return $this->hasMany(Lead::class);
}
<<<<<<< HEAD

public function sources()
{
    return $this->belongsto(Source::class);
}
public function projectLeads()
{
    return $this->hasMany(Lead::class, 'project_id', 'id');
}
=======
    public function sources()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
    public function campaigns()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
>>>>>>> 1434718 (live)
}
