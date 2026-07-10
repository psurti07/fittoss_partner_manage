<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsList extends Model
{
    use HasFactory;
    public $table = 'sms_list';
    public $timestamps = false;
    protected $fillable = ['id', 'company_id', 'rec_date', 'title', 'sms_slug', 'message', 'is_active'];

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
}
