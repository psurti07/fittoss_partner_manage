<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;

    protected $table = 'sms_log';
    public $timestamps = false;

    protected $fillable = [
        'rec_date',
        'company_id',
        'crontype',
        'product_id',
        'cronname',
        'msgcount',
        'msgresponse',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $query) {
            if (auth()->check() && app()->bound('company_id')) {
                $from = $query->getQuery()->from;
                if (str_contains($from, ' as ')) {
                    $alias = trim(explode(' as ', $from)[1]);
                } else {
                    $alias = $query->getModel()->getTable();
                }

                $query->where(
                    $alias . '.company_id',
                    app('company_id')
                );
            }
        });
    }
}
