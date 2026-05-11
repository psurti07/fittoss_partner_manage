<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    public const PAYMENT_FOLDER = 'payments';
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile_no',
        'product_id',
        'city',
        'pincode',
        'state',
        'order_id',
        'amount',
        'grand_total',
        'payment_image',
        'is_paid',
        'is_mobile_verified',
        'preferred_datetime',
        'password',
        'user_type',
        'refcode',
        'process_step',
        'is_user',
        'is_active',
        'is_agree',
        'is_dnd',
        'is_delete',
        'created_at',
        'updated_at',
    ];

    public function scopePaid($query)
    {
        return $query->where('is_paid', 1);
    }
    public function scopeUnpaid($query)
    {
        return $query->where('is_paid', 0);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function personalDetails()
    {
        return $this->hasOne(UserPersonalDetails::class, 'userid', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'userid', 'id');
    }
}
