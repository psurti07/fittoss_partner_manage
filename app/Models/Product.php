<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    public $timestamps = false;
    public const IMAGE_FOLDER = 'products';

    protected $fillable = [
        'productname',
        'product_title',
        'productslug',
        'rec_date',
        'amount',
        'offeramount',
        'inOffer',
        'description',
        'coach_name',
        'start_time',
        'end_time',
        'date',
        'language',
        'image',
        'is_active',
        'updated_at',
    ];

    protected $casts = [
        'amount' => 'float',
        'offeramount' => 'float',
        'date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time'   => 'datetime:H:i:s',
    ];
    protected $appends = ['image_url'];

    public function otps()
    {
        return $this->hasMany(OtpVerification::class, 'product_id', 'id');
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('productslug', $slug);
    }

    public function scopeOfferSlug($query, $slug)
    {
        return $query->select(
            'id',
            'productname',
            'amount',
            'offeramount',
            'inOffer'
        )
            ->slug($slug);
    }

    public function setDescriptionAttribute($value)
    {
        $cleaned = preg_replace('/>\s+</', '><', trim($value));
        $this->attributes['description'] = $cleaned;
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset("assets/uploads/" . self::IMAGE_FOLDER . "/{$this->image}")
            : asset("assets/images/no-image-icon.png");
    }
}
