<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSSetting extends Model
{
    use HasFactory;

    protected $table = 'sms_settings';

    protected $fillable = [
        'product_id',
        'sender_id',
        'remarketing_sender_id',
        'is_active',
        'updated_at'
    ];
}
