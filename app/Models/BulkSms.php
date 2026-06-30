<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkSms extends Model
{
    use HasFactory;
    public $table = 'bulksms';
    public $timestamps = false;
    protected $fillable = ['id', 'company_id', 'rec_date', 'fullname', 'email', 'mobile'];

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
