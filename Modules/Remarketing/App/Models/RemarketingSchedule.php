<?php

namespace Modules\Remarketing\App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RemarketingSchedule extends Model
{
    use HasFactory;

    protected $table = 'remarketing_schedules';

    protected $fillable = ['company_id', 'product_id', 'type', 'day', 'time', 'is_active', 'created_at', 'updated_at'];

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
