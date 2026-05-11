<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'id', 'rec_date','emp_id','check_in','check_out','work_time','isActive'
    ];  
    
    public $timestamps = false;
}
