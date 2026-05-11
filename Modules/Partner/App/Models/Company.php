<?php

namespace Modules\Partner\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    public const IMAGE_FOLDER = 'company';
    protected $appends = ['logo_url','icon_url'];

    protected $fillable = [
        'id',
        'partner_id',
        'company_code',
        'company_name',
        'company_email',
        'company_mobile_no',
        'company_gst_no',
        'company_fssai',
        'company_type',
        'company_address',
        'company_logo',
        'company_icon',
        'company_live_date',
        'project_name',
        'register_date',
        'website_url',
        'city',
        'state',
        'pincode',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'linkedin_url',
        'youtube_url',
        'pinterest_url',
        'is_verified',
        'is_active',
        'is_delete',
        'created_at',
        'updated_at',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function getLogoUrlAttribute()
    {
        return $this->company_logo
            ? asset("assets/uploads/" . self::IMAGE_FOLDER . "/{$this->company_logo}")
            : asset("assets/images/no-image-icon.png");
    }
    public function getIconUrlAttribute()
    {
        return $this->company_icon
            ? asset("assets/uploads/" . self::IMAGE_FOLDER . "/{$this->company_icon}")
            : asset("assets/images/no-image-icon.png");
    }
}
