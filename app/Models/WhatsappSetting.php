<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappSetting extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_settings';

    protected $fillable = [
        'company_id',
        'product_id',
        'event_name',
        'key',
        'template_name',
        'media_name',
        'media_url',
        'is_active'
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
