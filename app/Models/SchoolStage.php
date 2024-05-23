<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolStage extends Model
{
    private static $_stages = [
        0 => 'TK / RA',
        1 => 'Setingkat SD/MI',
        2 => 'Setingkat SMP/MTs',
        3 => 'Setingkat SMA/MA',
    ];

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'stage',
    ];

    public static function stages()
    {
        return static::$_stages;
    }

    public function stageFormatted()
    {
        return $this->stages()[$this->stage];
    }
}
