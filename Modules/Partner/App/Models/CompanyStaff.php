<?php

namespace Modules\Partner\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyStaff extends Model
{
    use HasFactory;
    protected $table = 'company_staff';

    // Roles
    public const ROLE_PARTNER = 1;
    public const ROLE_OFFICE_STAFF = 2;
    public const ROLE_IVR_SUPPORT_STAFF = 3;
    public const ROLE_IT_STAFF = 4;

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
            self::ROLE_PARTNER => 'Partner',
            self::ROLE_OFFICE_STAFF => 'Office Staff',
            self::ROLE_IVR_SUPPORT_STAFF => 'IVR/Support Staff',
            self::ROLE_IT_STAFF => 'IT Staff',
        ];
    }

    /**
     * Get Single Role Name
     */
    public static function getRoleName(int $role)
    {
        return self::roles()[$role] ?? 'Unknown';
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function isPartner()
    {
        return $this->role === self::ROLE_PARTNER;
    }
}
