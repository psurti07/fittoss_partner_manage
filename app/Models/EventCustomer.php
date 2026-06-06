<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Event\Models\Event;
use Modules\Partner\App\Models\Company;

class EventCustomer extends Model
{
    use HasFactory;
    public const TYPE_USER = 1;
    public const TYPE_LEAD = 0;

    protected $fillable = [
        'company_id',
        'event_id',
        'user_id',
        'order_id',
        'is_user',
        'is_attend',
        'is_enrolled',
        'points',
        'ref_id',
        'amount',
        'created_at',
        'updated_at',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && app()->bound('company_id')) {
                $from = $builder->getQuery()->from;
                if (str_contains($from, ' as ')) {
                    $alias = trim(explode(' as ', $from)[1]);
                } else {
                    $alias = $builder->getModel()->getTable();
                }

                $builder->where(
                    $alias . '.company_id',
                    app('company_id')
                );
            }
        });
    }


    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | Base Query
    |--------------------------------------------------------------------------
    */
    const DATATABLE_COLUMNS = [
        0 => 'ec.id',
        1 => 'ec.updated_at',
        2 => 'c.company_name',
        3 => 'e.title',
        4 => 'customers.first_name',
        5 => 'customers.mobile_no',
        6 => 'customers.email',
        7 => 'customers.city',
        8 => 'customers.state',
        9 => 'customers.pincode',
    ];

    public function scopeBaseCustomerQuery($query)
    {
        return $query
            ->leftJoin('customers', 'customers.id', '=', 'ec.user_id')
            ->leftJoin('companies as c', 'c.id', '=', 'ec.company_id')
            ->leftJoin('events as e', 'e.id', '=', 'ec.event_id')
            ->select(
                'ec.id',
                'ec.user_id',
                'ec.event_id',
                'ec.company_id',
                'ec.is_attend',
                'ec.is_enrolled',
                'customers.first_name',
                'customers.last_name',
                'customers.email',
                'customers.mobile_no',
                'customers.product_id',
                'customers.city',
                'customers.pincode',
                'customers.state',
                'customers.updated_at',
                'c.company_name',
                'e.title as event_title',
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
        return $query->where('ec.is_user', $isUser);
    }

    public function scopeEvent($query, $eventId)
    {
        if ($eventId) {
            return $query->where('ec.event_id', $eventId);
        }
        return $query;
    }

    public function scopeDateRange($query, $fromDate, $toDate)
    {
        if (!empty($fromDate) && !empty($toDate)) {
            $query->whereBetween('ec.updated_at', [
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
