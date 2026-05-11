<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    use HasFactory;

    protected $table = 'support_requests';
    protected $fillable = [
        'rec_date', 'ticketno', 'usertype', 'firstname', 'lastname', 'mobile', 'email', 'issuetype', 'message', 'status', 'serverip', 'is_delete'
    ];

    public $timestamps = false;
}
