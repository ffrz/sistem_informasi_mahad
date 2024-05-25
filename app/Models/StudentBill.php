<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentBill extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description', 'date', 'due_date', 'type_id',
        'student_id', 
        'amount', 'paid', 'total_paid', 
        'created_at', 'updated_at'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function type()
    {
        return $this->belongsTo(StudentBillType::class);
    }
}
