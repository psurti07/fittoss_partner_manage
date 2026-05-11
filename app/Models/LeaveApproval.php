<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApproval extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'leave_approval';
    protected $fillable = ['id','rec_date','emp_id','leave_id','total_leaves','leave_status','paid_leave','unpaid_leave','no_of_paid_leaves','no_of_unpaid_leaves','remarks'];
}
