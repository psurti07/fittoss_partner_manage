<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;
    protected $table = "otp_verifications";
    public $timestamps = false;
    protected $fillable = ['id', 'mobile', 'otp_code', 'product_id', 'is_used', 'rec_date', 'expires_at'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
