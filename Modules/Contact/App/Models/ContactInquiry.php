<?php

namespace Modules\Contact\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'contact_requests';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id', 'first_name', 'title',  'mobile_no', 'email', 'server_ip', 'message', 'is_active', 'is_delete'];
}
