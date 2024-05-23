<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_EXIT_OR_MOVED = 2;
    const STATUS_GRADUATED = 3;
    
    public $timestamps = false;

    private static $_statuses = [
        Student::STATUS_INACTIVE => 'Tidak Aktif',
        Student::STATUS_ACTIVE => 'Aktif',
        Student::STATUS_EXIT_OR_MOVED => 'Keluar / Pindah',
        Student::STATUS_GRADUATED => 'Lulus',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nis',
        'fullname',
        'stage_id',
        'level_id',
        'status'
    ];

    public function stage()
    {
        return $this->belongsTo(SchoolStage::class);
    }

    public function level()
    {
        return $this->belongsTo(SchoolLevel::class);
    }

    public function statusFormatted()
    {
        return self::statuses()[$this->status];
    }

    public static function statuses() {
        return self::$_statuses;
    }
}
