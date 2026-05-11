<?php

namespace Modules\BeforeAfterTestiMonial\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeforeAfterTestiMonial extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'before_after_testimonials';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id', 'name', 'before_image', 'after_image', 'title', 'description', 'service', 'days','rating', 'is_active', 'is_delete'];
}
