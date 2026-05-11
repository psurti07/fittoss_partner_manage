<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerEnquiry extends Model
{
    use HasFactory;

    protected $table = 'career_enquiry';

    protected $fillable = [
        'id',
        'rec_date',
        'firstname',
        'lastname',
        'email',
        'mobile',
        'applyfor',
        'resume',
        'qualification',
        'experience',
        'keyskills',
        'city',
        'server_ip',
        'is_delete',
    ];

    public $timestamps = false;
}
