<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentBillType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'stage_id', 'level_id', 'amount', 'created_at', 'updated_at'
    ];

    public function stage()
    {
        return $this->belongsTo(SchoolStage::class);
    }

    public function level()
    {
        return $this->belongsTo(SchoolLevel::class);
    }
}
