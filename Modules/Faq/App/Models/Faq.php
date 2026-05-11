<?php

namespace Modules\Faq\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'faqs';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id', 'question', 'answer', 'category_id', 'is_active', 'is_delete'];
}
