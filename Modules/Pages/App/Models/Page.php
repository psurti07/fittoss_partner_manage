<?php

namespace Modules\Pages\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'pages';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id', 'slug', 'status',  'content', 'rec_date'];
}
