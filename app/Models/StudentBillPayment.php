<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentBillPayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bill_id', 'date', 'amount', 'created_at', 'updated_at'
    ];
}
