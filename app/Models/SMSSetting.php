<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSSetting extends Model
{
    use HasFactory;

    protected $table = 'sms_settings';

    protected $fillable = [
        'product_id',
        'company_id',
        'username',
        'password',
        'sender_id',
        'remarketing_sender_id',
        'is_active',
        'updated_at'
    ];

    public function scopeCompany(Builder $query): Builder
    {
        if (auth()->check() && app()->bound('company_id')) {
            $from = $query->getQuery()->from;
            if (str_contains($from, ' as ')) {
                $alias = trim(explode(' as ', $from)[1]);
            } else {
                $alias = $this->getTable();
            }

            $query->where(
                $alias . '.company_id',
                app('company_id')
            );
        }
        return $query;
    }
}
