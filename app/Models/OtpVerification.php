<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class OtpVerification extends Model
{
    use HasFactory;
    protected $table = "otp_verifications";
    public $timestamps = false;
    protected $fillable = ['id', 'mobile', 'otp_code', 'product_id', 'is_used', 'company_id', 'rec_date', 'expires_at'];

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && app()->bound('company_id')) {
                $builder->where(
                    $builder->getModel()->getTable() . '.company_id',
                    app('company_id')
                );
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
