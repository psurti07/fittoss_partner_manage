<?php

namespace Modules\Partner\App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CompanyStaff extends Authenticatable
{
    use HasFactory;
    protected $table = 'company_staff';

    // Roles
    public const SUPER_ADMIN = 'super_admin';
    public const ADMIN = 'admin';
    public const STAFF = 'staff';
    // public const HR = 'hr';
    // public const OFFICE_STAFF = 'office_staff';
    // public const MARKETING = 'marketing';
    // public const ACCOUNTING = 'accounting';

    protected $fillable = [
        'id',
        'company_id',
        'name',
        'email',
        'mobile_no',
        'password',
        'role',
        'position',
        'staff_code',
        'is_active',
        'is_delete',
        'created_at',
        'updated_at',
    ];

    /**
     * Role Labels
     */
    public static function roles()
    {
        return [
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::STAFF => 'Staff',
        ];
    }
    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            if (app()->bound('company_id')) {
                $builder->where(
                    $builder->getModel()->getTable() . '.company_id',
                    app('company_id')
                );
            }
        });
    }

    /**
     * Get Single Role Name
     */
    public static function getRoleName(string $role)
    {
        return self::roles()[$role] ?? 'Unknown';
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /** Role base */
    public function hasRole(string $role): bool
    {
        return $this->role == $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::SUPER_ADMIN;
    }
}
