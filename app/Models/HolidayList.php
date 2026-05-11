<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayList extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'holiday_list';
    protected $fillable = ['id','rec_date', 'holiday_date' ,'holiday_name','holiday_type','isDelete'];
}
