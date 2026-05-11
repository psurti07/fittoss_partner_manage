<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'leave_application';
    protected $fillable = ['id','rec_date','emp_id','name' ,'department','leave_type','from_date','to_date', 'no_of_days','comments','half_day','from_time','to_time'];

    public function leaveApplication()
    {
        return $this->belongsTo(LeaveApplication::class, 'leave_id');
    }

}
