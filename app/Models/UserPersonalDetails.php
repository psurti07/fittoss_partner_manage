<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPersonalDetails extends Model
{
    use HasFactory;

    protected $table = 'user_personal_details';
    public $timestamps = false;

    protected $fillable = [
        'userid',
        'purpose',
        'active_rate',
        'medical_issue',
        'height',
        'weight',
        'bmi',
        'company_id',
        'age',
        'gender',
        'dob',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'dob' => 'date:Y-m-d',
        // 'medical_issue' => 'array',
    ];
}
