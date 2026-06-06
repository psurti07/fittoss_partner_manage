<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Partner\App\Models\Company;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    public const IMAGE_FOLDER = 'events';

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'amount',
        'offer_amount',
        'coach_name',
        'date',
        'start_time',
        'end_time',
        'language',
        'in_offer',
        'is_active',
        'image',
        'updated_at',
    ];

    protected $casts = [
        'amount' => 'float',
        'offer_amount' => 'float',
        'date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time'   => 'datetime:H:i:s',
    ];
    protected $appends = ['image_url'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
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
