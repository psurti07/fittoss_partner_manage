<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    public const PAYMENT_FOLDER = 'payments';
    public const TYPE_USER = 1;
    public const TYPE_LEAD = 0;
    public $timestamps = false;

    protected $fillable = [
        'company_id',
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

    // public function scopeCompany(Builder $query): Builder
    // {
    //     if (auth()->check() && app()->bound('company_id')) {
    //         $query->where(
    //             $this->getTable() . '.company_id',
    //             app('company_id')
    //         );
    //     }
    //     return $query;
    // }

    public function scopePaid($query)
    {
        return $query->where('is_user', 1);
    }
    public function scopeUnpaid($query)
    {
        return $query->where('is_user', 0);
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

    /*
    |--------------------------------------------------------------------------
    | Base Query
    |--------------------------------------------------------------------------
    */
    const DATATABLE_COLUMNS = [
        0 => 'customers.id',
        1 => 'customers.updated_at',
        2 => 'c.company_name',
        3 => 'customers.first_name',
        4 => 'customers.mobile_no',
        5 => 'customers.email',
        6 => 'customers.city',
        7 => 'customers.state',
        8 => 'customers.pincode',
    ];

    public function scopeBaseCustomerQuery($query)
    {
        return $query
            ->leftJoin('companies as c', 'c.id', '=', 'customers.company_id')
            ->select(
                'customers.id',
                'customers.first_name',
                'customers.last_name',
                'customers.email',
                'customers.mobile_no',
                'customers.product_id',
                'customers.city',
                'customers.pincode',
                'customers.state',
                'customers.updated_at',
                'c.company_name'
            )
            ->where('customers.is_active', 1)
            ->where('customers.is_delete', 0);
    }

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    public function scopeUserType($query, $isUser)
    {
        return $query->where('customers.is_user', $isUser);
    }

    public function scopeProduct($query, $productId)
    {
        return $query->where('customers.product_id', $productId);
    }

    public function scopeCompany($query, $companyId)
    {
        if ($companyId) {
            $query->where('customers.company_id', $companyId);
        }
        return $query;
    }

    public function scopeDateRange($query, $fromDate, $toDate)
    {
        if (!empty($fromDate) && !empty($toDate)) {
            $query->whereBetween('customers.updated_at', [
                $fromDate . ' 00:00:00',
                $toDate . ' 23:59:59'
            ]);
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('customers.mobile_no', 'like', "%{$search}%")
                    ->orWhere('customers.first_name', 'like', "%{$search}%")
                    ->orWhere('customers.email', 'like', "%{$search}%")
                    ->orWhere('customers.last_name', 'like', "%{$search}%")
                    ->orWhere('customers.city', 'like', "%{$search}%")
                    ->orWhere('customers.state', 'like', "%{$search}%");
            });
        }

        return $query;
    }
}
