<?php

// app/Models/Tag.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public function childStages()
    {
        // Adjust the relationship based on your actual column names
        return $this->hasMany(Stage::class, 'parent_stage_id', 'id');
    }

}
