<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\App\Models\Administrations;

class SupportRequestChat extends Model
{
    use HasFactory;

    protected $table = 'support_request_chat';

    protected $fillable = [
        'rec_date',
        'requestid',
        'remarks',
        'staffid',
        'is_delete'
    ];

    public $timestamps = false;

    public function administrations()
    {
        return $this->belongsTo(Administrations::class, 'staffid', 'id');
    }
}
