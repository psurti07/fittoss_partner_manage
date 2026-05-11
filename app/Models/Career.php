<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;
    protected $table = 'careers';

    protected $fillable = [
        'id', 'rec_date', 'slug', 'title', 'description', 'is_active', 'is_delete'
    ];

    public $timestamps = false;
}
