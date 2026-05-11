<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $table = 'diseases';

    protected $fillable = [
        'id', 'name', 'description', 'rec_date', 'is_delete', 'is_active'
    ];

    public $timestamps = false;
}
