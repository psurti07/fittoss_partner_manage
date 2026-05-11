<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'id', 'rec_date', 'name', 'mobile_no', 'email', 'password', 
        'department', 'dob', 'doj', 'resign_date', 'address', 'city', 'state', 
        'reference_name', 'reference_mobile', 'reference_dob', 'punching_code', 
        'salary', 'remarks', 'bonus_start_date', 'bonus_end_date', 'bonus_eligible_date', 
        'probation_start_date',  'probation_end_date', 'aadhaar_card', 'pan_card', 
        'passport_photo', 'cancel_cheque', 'address_proof', 'isApproved', 'isActive', 'isDelete'
    ];  
    
    public $timestamps = false;
}
