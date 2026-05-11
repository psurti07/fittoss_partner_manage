<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    use HasFactory;

    protected $table = 'contact_inquires';

    protected $fillable = [
        'name', 'email', 'mobile_no', 'subject', 'message', 'is_active', 'is_delete'
    ];
}
