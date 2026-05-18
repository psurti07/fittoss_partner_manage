<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleSlot extends Model
{
    use HasFactory;

    protected $table = 'schedule_slots';

    // Language constants
    const HINDI = 1;
    const ENGLISH = 2;
    const GUJARATI = 3;

    // Status constants
    const SCHEDULED = 1;
    const COMPLETED = 2;
    const CANCELLED = 3;
    const NOT_REACHABLE = 4;

    protected $fillable = [
        'user_id',
        'company_id',
        'product_id',
        'date',
        'time',
        'language',
        'remarks',
        'status',
        'is_deleted',
        'created_at',
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

    public static function getLanguages()
    {
        return [
            self::HINDI => 'Hindi',
            self::ENGLISH => 'English',
            self::GUJARATI => 'Gujarati',
        ];
    }

    public static function getStatuses()
    {
        return [
            self::SCHEDULED => 'Scheduled',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
            self::NOT_REACHABLE => 'Not Reachable',
        ];
    }

    public function getLanguageTextAttribute()
    {
        return self::getLanguages()[$this->language] ?? 'Unknown';
    }

    public function getStatusTextAttribute()
    {
        return self::getStatuses()[$this->status] ?? 'Unknown';
    }
}
