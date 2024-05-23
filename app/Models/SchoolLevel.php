<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolLevel extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'stage_id',
        'name',
        'level'
    ];
    
    public function stage()
    {
        return $this->belongsTo(SchoolStage::class);
    }
}
