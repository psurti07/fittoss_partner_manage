<?php

namespace Modules\Testimonial\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestiMonial extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'testimonials';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id', 'type', 'name', 'image', 'address', 'rating', 'review', 'is_active', 'is_delete'];
}
