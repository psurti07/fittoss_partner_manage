<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WelcomeImageFlyer extends Model
{
    use HasFactory;
    protected $table = 'welcome_image_flyer';
    protected $fillable = ['id','flyer_img', 'flyer_name', 'is_active', 'is_delete'];
    public $timestamps = false;
}
