<?php

namespace Modules\Partner\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    use HasFactory;
    protected $table = 'partners';
    public const IMAGE_FOLDER = 'partners';
    protected $appends = ['image_url'];

    protected $fillable = [
        'id',
        'name',
        'mobile_no',
        'email',
        'password',
        'address',
        'dob',
        'image',
        'is_active',
        'is_delete',
        'created_at',
        'updated_at',
    ];

    public function company()
    {
        return $this->hasOne(Company::class, 'partner_id', 'id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset("assets/uploads/" . self::IMAGE_FOLDER . "/{$this->image}")
            : asset("assets/images/no-image-icon.png");
    }
}
