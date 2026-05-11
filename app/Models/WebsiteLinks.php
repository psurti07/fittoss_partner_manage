<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteLinks extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'website_links';

    protected $fillable = ['id', 'rec_date', 'title', 'link', 'short_link', 'isActive', 'isDelete'];
}
