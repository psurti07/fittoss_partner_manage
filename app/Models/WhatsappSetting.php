<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappSetting extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_settings';

    protected $fillable = [
        'product_id',
        'event_name',
        'key',
        'template_name',
        'media_name',
        'media_url',
        'is_active'
    ];
}
